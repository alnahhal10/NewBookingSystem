<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createSession(Booking $booking)
    {
        if ($booking->payment_status === 'paid') {
            return redirect()->route('my.bookings')->with('error', 'This booking has already been paid.');
        }

        $room = $booking->room->roomType->hotel->name . ' - ' . $booking->room->roomType->name . ' Room #' . $booking->room->room_number;

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Booking: ' . $room,
                        'description' => 'Check-in: ' . $booking->check_in->format('M d, Y') . ' | Check-out: ' . $booking->check_out->format('M d, Y'),
                    ],
                    'unit_amount' => (int)($booking->total_price * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payments.success', ['booking' => $booking->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payments.cancel', ['booking' => $booking->id]),
            'metadata' => [
                'booking_id' => $booking->id,
            ],
        ]);

        $booking->update(['stripe_session_id' => $session->id]);

        return redirect($session->url);
    }

    public function success(Request $request, Booking $booking)
    {
        $session = Session::retrieve($request->query('session_id'));

        if ($session->payment_status !== 'paid') {
            return redirect()->route('my.bookings')->with('error', 'Payment not confirmed.');
        }

        if ($booking->stripe_session_id !== $session->id) {
            return redirect()->route('my.bookings')->with('error', 'Invalid payment session.');
        }
        
            // fallback لو الـ webhook تأخر
        if ($booking->payment_status !== 'paid') {
            $booking->update(['payment_status' => 'paid', 'status' => 'confirmed']);
        }


        return redirect()->route('my.bookings')->with('success', 'Payment successful! Your booking is confirmed.');
    }

    public function cancel(Booking $booking)
    {
        return redirect()->route('my.bookings')->with('error', 'Payment was cancelled. Please try again.');
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $webhook_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $webhook_secret);
        } catch (\Exception $e) {
            // 1. تسجيل فشل التحقق من التوقيع (أمني وتقني)
            Log::error('Stripe Webhook Signature Verification Failed', [
            'error' => $e->getMessage(),
            'payload_sample' => substr($payload, 0, 100) // نأخذ جزء بسيط فقط للأمان
        ]);
            return response()->json(['error' => 'Webhook Error: ' . $e->getMessage()], 400);
        }

        // 2. تسجيل وصول الـ Event بنجاح (مفيد جداً للتتبع)
    Log::info('Stripe Webhook Received', ['event_type' => $event->type]);

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $booking = Booking::where('stripe_session_id', $session->id)->first();

            if ($booking) {
                $booking->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                ]);
                // 3. تسجيل نجاح عملية التحديث
            Log::info('Booking Confirmed via Webhook', [
                'booking_id' => $booking->id,
                'stripe_session_id' => $session->id
            ]);

            }else{
                // 4. كارثة: Stripe أخبرنا بالدفع ولكن لا نجد الحجز في قاعدة بياناتنا!
            Log::warning('Stripe Payment Received but Booking Not Found', [
                'stripe_session_id' => $session->id,
                'customer_email' => $session->customer_details->email ?? 'N/A'
            ]);
            }
        }

        return response()->json(['received' => true]);
    }
}

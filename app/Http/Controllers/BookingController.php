<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookingRequest;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with('room.roomType.hotel')
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $roomId = $request->query('room_id');
        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');

        $room = null;
        $nights = 0;
        $totalPrice = 0;
 
        if ($roomId) {
            $room = Room::with('roomType.hotel')->find($roomId);

            if ($room && $checkIn && $checkOut) {
                $nights = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));
                $totalPrice = $nights * $room->roomType->base_price;
            }
        }

        if (! $room) {
            return redirect()->route('home')->with('error', 'Please choose a room before booking.');
        }

        if (! $checkIn || ! $checkOut) {
            return redirect()
                ->route('hotels.show', $room->roomType->hotel)
                ->with('error', 'Please select check-in and check-out dates before booking.');
        }

        return view('bookings.create', compact('room', 'checkIn', 'checkOut', 'nights', 'totalPrice'));
    }

    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $room = Room::with('roomType')->findOrFail($request->room_id);

        if (! $room->isAvailable($request->check_in, $request->check_out)) {
            return redirect()->back()->with('error', 'Sorry, this room is not available for the selected dates.');
        }

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);

        $totalPrice = $nights * $room->roomType->base_price;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
            'payment_status' => 'pending',
        ]);

        return redirect()->route('bookings.pay', ['booking' => $booking->id]);
    }
}

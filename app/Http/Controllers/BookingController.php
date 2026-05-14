<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookingRequest;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService) 
    {
        $this->bookingService = $bookingService;
    }

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
       
        $room = Room::with('roomType.hotel')->find($request->room_id);

            if (! $room) {
                return redirect()->route('home')
                    ->with('error', 'Please choose a room before booking.');
            }

            $checkIn  = $request->check_in;
            $checkOut = $request->check_out;

            if (! $checkIn || ! $checkOut) {
                return redirect()
                    ->route('hotels.show', $room->roomType->hotel)
                    ->with('error', 'Please select check-in and check-out dates.');
            }

            $details = $this->bookingService->calculateBookingDetails($room, $checkIn, $checkOut);

            return view('bookings.create', array_merge(
                compact('room', 'checkIn', 'checkOut'),
                $details
            ));
 
    }

    public function store(StoreBookingRequest $request)
    {
       

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

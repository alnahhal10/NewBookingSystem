<?php
namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingService
{
    public function calculateBookingDetails(Room $room, string $checkIn, string $checkOut): array
    {
        $nights = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));
        $totalPrice = $nights * $room->roomType->base_price;

        return compact('nights', 'totalPrice');
    }

    public function createBooking(Room $room, string $checkIn, string $checkOut): Booking
    {
        if (! $room->isAvailable($checkIn, $checkOut)) {
            throw new \Exception('Sorry, this room is not available for the selected dates.');
        }

        ['totalPrice' => $totalPrice] = $this->calculateBookingDetails($room, $checkIn, $checkOut);

        return Booking::create([
            'user_id'        => Auth::id(),
            'room_id'        => $room->id,
            'check_in'       => $checkIn,
            'check_out'      => $checkOut,
            'total_price'    => $totalPrice,
            'status'         => 'confirmed',
            'payment_status' => 'pending',
        ]);
    }
}
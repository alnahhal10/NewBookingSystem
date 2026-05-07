<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $guarded = [];


    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function bookings()
{
    return $this->hasMany(Booking::class);
}

// Check if the room is available for a specific date range
public function isAvailable($checkIn, $checkOut)
{
    // Count overlaps
    // A booking overlaps if:
    // (Existing Check-In < New Check-Out) AND (Existing Check-Out > New Check-In)
    
    $overlaps = $this->bookings()
        ->where('status', '!=', 'cancelled') // Ignore cancelled bookings
        ->where('check_in', '<', $checkOut)
        ->where('check_out', '>', $checkIn)
        ->count();

    return $overlaps === 0; // True if no overlaps found
}


}

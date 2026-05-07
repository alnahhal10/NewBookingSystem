<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = ['user_id', 'room_id', 'check_in', 'check_out', 'total_price', 'status', 'stripe_session_id', 'payment_status'];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

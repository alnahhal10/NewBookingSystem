<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    /** @use HasFactory<\Database\Factories\HotelFactory> */
    use HasFactory;
    
    // تحديد الجدول المرتبط بالنموذج
    protected $table = 'hotels';
     
    protected $fillable = [
        'user_id',
        'name',
        'city',
        'state',
        'description',
        'address',
        'phone_number',
        'email',
        'country',
        'images',
    ];



    public function getMinPriceAttribute()
{
    // Get lowest base_price from all room types
    return $this->roomTypes()->min('base_price') ?? 0;
}


    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }


    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function rooms()
    {
        return $this->hasManyThrough(Room::class, RoomType::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function availableRooms($checkIn, $checkOut)
    {
        return $this->rooms()->whereDoesntHave('bookings', function($query) use ($checkIn, $checkOut) {
            $query->where(function($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out', [$checkIn, $checkOut]);
            })->whereNotIn('status', ['cancelled']);
        });
    }

    // Accessor and Mutator examples
    //getter and setter for name attribute
    //get the name in uppercase
    //   protected function name(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => strtoupper($value),
    //     );
    // }
    
    //set the first name to lowercase when saving to database
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    /**
     * Use the slug column for route model binding instead of the id.
     */
    

} 

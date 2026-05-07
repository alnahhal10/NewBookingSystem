<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
    use App\Models\Room; // Add this at the top if not present
use Carbon\Carbon;   // Add this at the top if not present

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Example in HomeController.php
public function index(Request $request)
{
    // Start query for Hotels
    $query = Hotel::query(); 

    // 1. Filter by City (if provided)
    if ($request->filled('city')) {
        $query->where('city', 'like', '%' . $request->city . '%');
    }

    // 2. Filter by Availability (if dates provided)
    if ($request->filled('check_in') && $request->filled('check_out')) {
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        // Only get Hotels that have at least one Room available
        // Logic: Hotel -> has RoomTypes -> has Rooms -> whereDoesntHave Overlapping Bookings
        $query->whereHas('roomTypes.rooms', function ($room) use ($checkIn, $checkOut) {
            $room->where('status', 'available')
                 ->whereDoesntHave('bookings', function ($booking) use ($checkIn, $checkOut) {
                     $booking->where('status', '!=', 'cancelled')
                             ->where('check_in', '<', $checkOut)
                             ->where('check_out', '>', $checkIn);
                 });
        });
    }

    // Get results
    $hotels = $query->paginate(10);  // or paginate()

    return view('landing', compact('hotels'));
}


    // public function index(Request $request)
    // {
    //     // Get the city from the query parameters
    //     $city = $request->query('city');

    //     // Fetch hotels based on the city filter, if provided
    //     $hotels = Hotel::when($city, function ($query, $city) {
    //         $query->where('city', 'like', "%{$city}%");
    //     })->paginate(6);

    //     return view('landing', compact('hotels', 'city'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
{
    $validatedData = $request->validated(); // ← أولاً
    $validatedData['user_id'] = auth()->id();

    if ($request->hasFile('image')) {
    $cloudinary = new Cloudinary(
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ]
        ])
    );
    
    $result = $cloudinary->uploadApi()->upload($request->file('image')->getRealPath());
    $validatedData['images'] = json_encode([$result['secure_url']]);
}


    Hotel::create($validatedData);

    return redirect()->route('hotels.index')->with('success', 'Hotel created successfully');
}

    /**
     * Display the specified resource.
     */


public function show(Hotel $hotel, Request $request)
{
    $checkIn = $request->input('check_in');
    $checkOut = $request->input('check_out');

    $roomsQuery = Room::whereHas('roomType', function($q) use ($hotel) {
            $q->where('hotel_id', $hotel->id);
        })
        ->where('status', 'available')
        ->with('roomType');

    // فلتر التواريخ فقط إذا تم تمريرها
    if ($checkIn && $checkOut) {
        $roomsQuery->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
            $q->where('status', '!=', 'cancelled')
              ->where('check_in', '<', $checkOut)
              ->where('check_out', '>', $checkIn);
        });
    }

    $availableRooms = $roomsQuery->get();

    return view('hotels.show', compact('hotel', 'availableRooms', 'checkIn', 'checkOut'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        //
        return view('hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        //
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
    $cloudinary = new Cloudinary(
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ]
        ])
    );
    
    $result = $cloudinary->uploadApi()->upload($request->file('image')->getRealPath());
    $validatedData['images'] = json_encode([$result['secure_url']]);
}

        $hotel->update($validatedData);
        return redirect()->route('hotels.show', $hotel->id)->with('success', 'Hotel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        //
        $hotel->delete();
        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully');
    }
}

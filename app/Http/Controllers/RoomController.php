<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\RoomType;

class RoomController extends Controller
{
    //
    public function index(Request $request)
{
    // Start the query: Get Rooms with Type and Hotel info
    $query = Room::with('roomType.hotel')
                ->where('status', 'available');

    // 1. Filter by City (if provided)
    if ($request->filled('city')) {
        $city = $request->input('city');
        // Search for rooms where the hotel is in that city
        $query->whereHas('roomType.hotel', function ($q) use ($city) {
            $q->where('city', 'like', '%' . $city . '%');
        });
    }

    // 2. Filter by Availability Dates (if provided)
    if ($request->filled('check_in') && $request->filled('check_out')) {
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');

        // Exclude rooms that have overlapping bookings
        // Logic: A room is unavailable if (Existing Check-In < New Check-Out) 
        // AND (Existing Check-Out > New Check-In)
        $query->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
            $q->where('status', '!=', 'cancelled') // Ignore cancelled bookings
              ->where('check_in', '<', $checkOut)
              ->where('check_out', '>', $checkIn);
        });
    }

    // Execute the query
    $rooms = $query->get();

    return response()->json([
        'success' => true,
        'data' => $rooms
    ]);
}



public function create(Hotel $hotel)
    {
        $roomTypes = RoomType::where('hotel_id', $hotel->id)->get();
    
        // dd($roomTypes);
        

        return view('rooms.create', compact('hotel', 'roomTypes'));
    }


    public function store(Request $request, Hotel $hotel)
{
    $request->validate([
        'room_type_id' => 'required|exists:room_types,id',
        'room_number'  => 'required|string|max:10',
        'status'       => 'required|in:available,maintenance,occupied',
        'floor_number'  => 'nullable|integer',
    ]);

    Room::create([
        'room_type_id' => $request->room_type_id,
        'room_number'  => $request->room_number,
        'status'       => $request->status,
        'floor_number' => $request->floor_number,
    ]);

    return redirect()->route('hotels.show', $hotel)
                     ->with('success', 'Room added successfully!');
}

}

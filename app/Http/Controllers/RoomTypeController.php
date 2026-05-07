<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function create(Hotel $hotel)
    {
        return view('roomstype.create', compact('hotel'));
    }

    public function store(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'base_price' => 'required|numeric',
            'max_adults' => 'required|integer',
            'bed_type' => 'required|string',
        ]);

        $roomType = $hotel->roomTypes()->create($validated);

        return redirect()->route('hotels.show', $hotel->id)
                         ->with('success', 'Room type created successfully!');
    }
}
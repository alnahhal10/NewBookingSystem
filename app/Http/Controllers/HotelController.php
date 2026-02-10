<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the city from the query parameters
        $city = $request->query('city');

        // Fetch hotels based on the city filter, if provided
        $hotels = Hotel::when($city, function ($query, $city) {
            $query->where('city', 'like', "%{$city}%");
        })->paginate(5);

        return view('landing', compact('hotels', 'city'));
    }

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
        //
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id(); // Assuming the user is authenticated
        Hotel::create($validatedData);
        return $request;
        // return redirect()->route('hotels.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        //
        return view('hotels.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        //
    }
}

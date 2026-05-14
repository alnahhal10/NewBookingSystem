<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    //



    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with('room.roomType.hotel')
            ->latest()
            ->get();


    

        return view('bookings.index', compact('bookings'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PaymentController;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Support\Facades\Route;

class UserDashboardController extends Controller
{
    //

    public function index(){
        $hotels = Hotel::withCount(['roomTypes', 'rooms'])
            ->latest()
            ->get();

        $rooms = Room::with(['roomType.hotel'])
            ->latest()
            ->get();

        $bookings = Booking::with(['user', 'room.roomType.hotel'])
            ->latest()
            ->get();

        $roomStatusCounts = $rooms->countBy('status');

        
        return view('userdashboard', compact('hotels','rooms','bookings','roomStatusCounts'));

    }
}

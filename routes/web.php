<?php

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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {

   Route::get('/userdashboard', [UserDashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:user'])->name('userdashboard');
    Route::get('/', [HotelController::class, 'index'])->name('home');

    Route::get('/dashboard', function () {
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

        return view('dashboard', [
            'hotels' => $hotels,
            'rooms' => $rooms,
            'bookings' => $bookings,
            'availableRoomsCount' => $roomStatusCounts->get('available', 0),
            'unavailableRoomsCount' => $roomStatusCounts->only(['maintenance', 'booked', 'out_of_service'])->sum(),
        ]);
    })->middleware(['auth', 'verified', 'role:admin'])->name('dashboard');
    

    // للجميع - عرض فقط
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // للأدمن فقط - إنشاء وتعديل وحذف
    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/hotels/create', [HotelController::class, 'create'])->name('hotels.create');
        Route::post('/hotels', [HotelController::class, 'store'])->name('hotels.store');
        Route::get('/hotels/{hotel}/edit', [HotelController::class, 'edit'])->name('hotels.edit');
        Route::put('/hotels/{hotel}', [HotelController::class, 'update'])->name('hotels.update');
        Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy'])->name('hotels.destroy');
    });

    // Public hotel details. Keep this after /hotels/create so "create" is not treated as a hotel id.
    Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');

    Route::middleware(['auth'])->group(function () {
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/my-bookings', [BookingController::class, 'index'])->name('my.bookings');
        Route::match(['GET', 'POST'], '/bookings/{booking}/pay', [PaymentController::class, 'createSession'])->name('bookings.pay');
        Route::get('/payments/success/{booking}', [PaymentController::class, 'success'])->name('payments.success');
        Route::get('/payments/cancel/{booking}', [PaymentController::class, 'cancel'])->name('payments.cancel');
    });

    Route::post('/webhook/stripe', [PaymentController::class, 'webhook'])->name('webhook.stripe');

    Route::get('/rooms', [RoomController::class, 'index']);

    // Create a physical Room for a specific Room Type
    Route::post('/room-types/{roomType}/rooms', [RoomController::class, 'store']);

    // Create a Room Type for a specific Hotel
    Route::post('/hotels/{hotel}/room-types', [RoomTypeController::class, 'store']);

    Route::get('/hotels/{hotel}/roomstypes/create', [RoomTypeController::class, 'create'])->name('room-types.create');
    Route::post('/hotels/{hotel}/room-types', [RoomTypeController::class, 'store'])->name('room-types.store');

    Route::get('/hotels/{hotel}/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/hotels/{hotel}/rooms', [RoomController::class, 'store'])->name('rooms.store');

    Route::get('send', function () {
        Mail::to('alnhal10@gmail.com')->send(new TestMail());
        return response()->json(['message' => 'Email sent successfully']);
    });

   
});
    

require __DIR__.'/auth.php';

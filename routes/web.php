<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProfileController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Route;

Route::get('/', [HotelController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('hotels', HotelController::class)->names(['index' => 'hotels'])->middleware(['auth']);


Route::get('send', function () {
    Mail::to('alnhal10@gmail.com')->send(new TestMail());
    return response()->json(['message' => 'Email sent successfully']);
});


require __DIR__.'/auth.php';

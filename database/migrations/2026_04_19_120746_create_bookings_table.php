<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // 1. Who made the booking (Breeze User)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // 2. Which room was booked
        $table->foreignId('room_id')->constrained()->onDelete('cascade');

        // 3. Booking Details
        $table->date('check_in');
        $table->date('check_out');
        $table->decimal('total_price', 10, 2);
        
        // 4. Status (confirmed, cancelled, completed)
        $table->enum('status', ['confirmed', 'cancelled', 'completed'])->default('confirmed');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

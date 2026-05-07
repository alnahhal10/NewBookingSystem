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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            // IMPORTANT: This links the room type to a specific hotel
            
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');

            $table->string('name'); // e.g., "Deluxe", "Suite"
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2); // Price per night
            $table->integer('max_adults')->default(2);
            $table->integer('max_children')->default(0);
            $table->string('bed_type')->default('King'); // King, Twin, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};

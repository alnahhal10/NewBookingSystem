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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            
        // Link to RoomType
        $table->foreignId('room_type_id')->constrained()->onDelete('cascade');
        
        $table->string('room_number'); // e.g., "101"
        $table->integer('floor_number');
        
        // Status: available, booked, maintenance
        $table->enum('status', ['available', 'booked', 'maintenance', 'out_of_service'])->default('available');
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

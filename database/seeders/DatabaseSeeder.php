<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the RoleAndPermissionSeeder first
        // $this->call(RoleAndPermissionSeeder::class);

        // Call the HotelSeeder
        // $this->call(HotelSeeder::class);

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('password'),
        // ]);

        // 1. Create a Hotel
        $hotel = \App\Models\Hotel::create([
            'name' => 'Grand Azure Resort',
            'address' => '123 Ocean Drive',
            'city' => 'Miami',
            'state' => 'Florida',
            'country' => 'USA',
            'postal_code' => '33139',
            'phone_number' => '+1 305-555-1234',
            'email' => 'contact@grandazure.com',
            'description' => 'A luxurious beachfront resort offering stunning ocean views.',
            'user_id' => 1, // Ensure this user exists!
            // Fix: Use json_encode for the JSON column
            'images' => json_encode(['https://example.com/images/grand-azure-resort.jpg']), 
        ]);

    

    // 2. Create Room Types for this Hotel
    $standardType = \App\Models\RoomType::create([
        'hotel_id' => $hotel->id,
        'name' => 'Standard Room',
        'description' => 'Cozy room with a garden view.',
        'base_price' => 100.00,
        'max_adults' => 2,
        'max_children' => 1,
        'bed_type' => 'Queen'
    ]);

    $deluxeType = \App\Models\RoomType::create([
        'hotel_id' => $hotel->id,
        'name' => 'Deluxe Suite',
        'description' => 'Spacious suite with ocean view.',
        'base_price' => 250.00,
        'max_adults' => 2,
        'max_children' => 2,
        'bed_type' => 'King'
    ]);

    // 3. Create Physical Rooms (Inventory)
    // Create 3 Standard Rooms (Room 101, 102, 103)
    foreach ([101, 102, 103] as $number) {
        \App\Models\Room::create([
            'room_type_id' => $standardType->id,
            'room_number' => (string)$number,
            'floor_number' => 1,
            'status' => 'available'
        ]);
    }

    // Create 2 Deluxe Rooms (Room 201, 202)
    foreach ([201, 202] as $number) {
        \App\Models\Room::create([
            'room_type_id' => $deluxeType->id,
            'room_number' => (string)$number,
            'floor_number' => 2,
            'status' => 'available'
        ]);
    }
    }
}

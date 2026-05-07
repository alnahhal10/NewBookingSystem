<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Hotel',
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'country' => $this->faker->country,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

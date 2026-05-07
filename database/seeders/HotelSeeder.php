<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'الرياض',
            'جدة',
            'مكة المكرمة',
            'المدينة المنورة',
            'الدمام',
            'الخبر',
            'أبها',
            'الطائف',
            'تبوك',
            'حائل'
        ];

        foreach ($cities as $city) {
            \App\Models\Hotel::factory()->create([
                'city' => $city,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        Venue::firstOrCreate(
            ['name' => 'Главный театр'],
            ['address' => 'ул. Театральная, 1', 'city' => 'Город', 'postal_code' => '000000', 'country' => 'Россия', 'phone' => '+7 900 000 0000', 'email' => 'info@theater.local']
        );

        Venue::firstOrCreate(
            ['name' => 'Малый зал'],
            ['address' => 'ул. Театральная, 2', 'city' => 'Город', 'postal_code' => '000001', 'country' => 'Россия']
        );
    }
}

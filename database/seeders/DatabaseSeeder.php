<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\VenueSeeder::class,
            \Database\Seeders\GenreSeeder::class,
            \Database\Seeders\PriceTierSeeder::class,
            \Database\Seeders\ShowSeeder::class,
            \Database\Seeders\PerformanceSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name' => 'Драма', 'description' => 'Серьёзные постановки'],
            ['name' => 'Комедия', 'description' => 'Лёгкие постановки для настроения'],
            ['name' => 'Трагедия', 'description' => 'Тяжёлые драматические постановки'],
            ['name' => 'Мюзикл', 'description' => 'Музыкальные спектакли с пением']
        ];

        foreach ($genres as $g) {
            Genre::firstOrCreate(['name' => $g['name']], $g);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Show;
use App\Models\Venue;
use App\Models\Genre;

class ShowSeeder extends Seeder
{
    public function run(): void
    {
        $venue = Venue::first();
        if (!$venue) return;

        $drama = Genre::where('name', 'Драма')->first();
        $comedy = Genre::where('name', 'Комедия')->first();

        $s1 = Show::firstOrCreate(
            ['title' => 'Ревизор'],
            [
                'description' => 'Классическая комедия Гоголя',
                'duration_minutes' => 120,
                'language' => 'Русский',
                'age_rating' => '12+',
                'venue_id' => $venue->id,
                'poster_url' => '/images/revizor.jpg'
            ]
        );

        $s2 = Show::firstOrCreate(
            ['title' => 'Гроза'],
            [
                'description' => 'Драма Островского',
                'duration_minutes' => 140,
                'language' => 'Русский',
                'age_rating' => '16+',
                'venue_id' => $venue->id,
                'poster_url' => '/images/groza.jpg'
            ]
        );

        if ($comedy) $s1->genres()->syncWithoutDetaching([$comedy->id]);
        if ($drama) $s2->genres()->syncWithoutDetaching([$drama->id]);
    }
}

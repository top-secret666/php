<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Venue;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Show>
 */
class ShowFactory extends Factory
{
    public function definition(): array
    {
        return [
            'venue_id' => Venue::factory(),
            'title' => $this->faker->sentence(3),
            'director' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'duration_minutes' => $this->faker->numberBetween(60,180),
            'language' => 'en',
            'age_rating' => 'PG',
        ];
    }
}

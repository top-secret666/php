<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Show;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Performance>
 */
class PerformanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'show_id' => Show::factory(),
            'starts_at' => $this->faker->dateTimeBetween('+1 days', '+30 days'),
            'ends_at' => $this->faker->dateTimeBetween('+31 days', '+60 days'),
            'status' => 'scheduled',
            'notes' => $this->faker->sentence(),
        ];
    }
}

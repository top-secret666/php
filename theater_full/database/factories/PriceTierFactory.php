<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Venue;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceTier>
 */
class PriceTierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'venue_id' => Venue::factory(),
            'name' => $this->faker->randomElement(['Standard','Premium','VIP']),
            'amount_cents' => $this->faker->numberBetween(1000,10000),
            'currency' => 'USD',
            'description' => $this->faker->sentence(),
        ];
    }
}

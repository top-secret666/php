<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SeatSection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'section_id' => SeatSection::factory(),
            'row' => $this->faker->numberBetween(1,50),
            'number' => $this->faker->numberBetween(1,200),
            'seat_type' => 'standard',
            'is_active' => true,
        ];
    }
}

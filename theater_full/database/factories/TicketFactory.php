<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Performance;
use App\Models\Seat;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'performance_id' => Performance::factory(),
            'seat_id' => Seat::factory(),
            'order_id' => Order::factory(),
            'purchaser_id' => User::factory(),
            'price' => $this->faker->randomFloat(2,10,200),
            'status' => 'issued',
            'qr_code' => bin2hex(random_bytes(8)),
        ];
    }
}

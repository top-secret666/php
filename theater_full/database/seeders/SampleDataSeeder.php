<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Venue, Show, SeatSection, Seat, Performance, PriceTier, Order, Ticket};
use Illuminate\Support\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Additional users
        User::factory()->count(20)->create();

        // Additional venues and shows
        $venues = Venue::factory()->count(3)->create();
        $shows = Show::factory()->count(8)->create([
            'venue_id' => $venues->random()->id,
        ]);

        // Seat sections and seats per venue
        foreach ($venues as $venue) {
            $sections = SeatSection::factory()->count(3)->create([
                'venue_id' => $venue->id,
            ]);

            foreach ($sections as $section) {
                Seat::factory()->count(30)->create([
                    'section_id' => $section->id,
                ]);
            }

            // Price tiers per venue
            PriceTier::factory()->count(3)->create([
                'venue_id' => $venue->id,
            ]);
        }

        // Performances per show
        foreach ($shows as $show) {
            for ($i = 1; $i <= 3; $i++) {
                $starts = Carbon::now()->addDays($i)->setTime(19, 0);
                Performance::factory()->create([
                    'show_id' => $show->id,
                    'venue_id' => $show->venue_id,
                    'starts_at' => $starts,
                    'ends_at' => $starts->copy()->addMinutes($show->duration_minutes ?? 120),
                    'status' => 'scheduled',
                ]);
            }
        }

        // Orders and tickets
        $orders = Order::factory()->count(15)->create();
        $performances = Performance::all();
        $seats = Seat::all();

        foreach ($performances as $performance) {
            $pickedSeats = $seats->random(min(10, $seats->count()));

            foreach ($pickedSeats as $seat) {
                $order = $orders->random();
                Ticket::firstOrCreate(
                    [
                        'performance_id' => $performance->id,
                        'seat_id' => $seat->id,
                    ],
                    [
                        'order_id' => $order->id,
                        'purchaser_id' => $order->user_id,
                        'price' => 1200.00,
                        'status' => 'sold',
                        'qr_code' => bin2hex(random_bytes(8)),
                        'issued_at' => now(),
                    ]
                );
            }
        }
    }
}

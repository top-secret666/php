<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Performance, Seat, PriceTier, Ticket, PerformanceStat};

class PerformanceStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_stats_created_on_ticket_sold()
    {
        $performance = Performance::factory()->create();
        $seat = Seat::factory()->create();
        $tier = PriceTier::factory()->create(['amount_cents' => 1500]);

        $response = $this->post(route('tickets.store'), [
            'performance_id' => $performance->id,
            'seat_id' => $seat->id,
            'price_tier_id' => $tier->id,
            'status' => 'sold',
        ]);

        $response->assertStatus(302);

        $stat = PerformanceStat::where('performance_id', $performance->id)->first();
        $this->assertNotNull($stat);
        $this->assertEquals(1, $stat->tickets_sold);
        $this->assertEquals('15.00', $stat->revenue);
    }

    public function test_stats_increment_checked_in()
    {
        $ticket = Ticket::factory()->create([
            'status' => 'sold',
            'checked_in_at' => null,
        ]);

        $response = $this->put(route('tickets.update', $ticket), [
            'performance_id' => $ticket->performance_id,
            'seat_id' => $ticket->seat_id,
            'status' => 'sold',
            'checked_in_at' => now()->toDateTimeString(),
        ]);

        $response->assertStatus(302);

        $stat = PerformanceStat::where('performance_id', $ticket->performance_id)->first();
        $this->assertNotNull($stat);
        $this->assertEquals(1, $stat->checked_in_count);
    }
}

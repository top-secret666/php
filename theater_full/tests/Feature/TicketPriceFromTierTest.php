<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Performance, Seat, PriceTier, Ticket};

class TicketPriceFromTierTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_price_is_set_from_price_tier()
    {
        $performance = Performance::factory()->create();
        $seat = Seat::factory()->create();
        $tier = PriceTier::factory()->create([
            'amount_cents' => 1234,
        ]);

        $response = $this->post(route('tickets.store'), [
            'performance_id' => $performance->id,
            'seat_id' => $seat->id,
            'price_tier_id' => $tier->id,
            'status' => 'reserved',
        ]);

        $response->assertStatus(302);

        $ticket = Ticket::first();
        $this->assertNotNull($ticket);
        $this->assertEquals('12.34', $ticket->price);
    }
}

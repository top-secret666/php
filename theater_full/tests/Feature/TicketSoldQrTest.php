<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Ticket;

class TicketSoldQrTest extends TestCase
{
    use RefreshDatabase;

    public function test_sold_ticket_gets_qr_code()
    {
        $ticket = Ticket::factory()->create([
            'status' => 'reserved',
            'qr_code' => null,
        ]);

        $response = $this->put(route('tickets.update', $ticket), [
            'performance_id' => $ticket->performance_id,
            'seat_id' => $ticket->seat_id,
            'status' => 'sold',
        ]);

        $response->assertStatus(302);

        $ticket->refresh();
        $this->assertEquals('sold', $ticket->status);
        $this->assertNotEmpty($ticket->qr_code);
    }
}

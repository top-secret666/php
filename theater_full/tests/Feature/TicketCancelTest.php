<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User, Ticket};

class TicketCancelTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_can_be_cancelled()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'status' => 'reserved',
            'qr_code' => null,
        ]);

        $response = $this->actingAs($user)->put(route('tickets.update', $ticket), [
            'performance_id' => $ticket->performance_id,
            'seat_id' => $ticket->seat_id,
            'status' => 'cancelled',
        ]);

        $response->assertStatus(302);

        $ticket->refresh();
        $this->assertEquals('cancelled', $ticket->status);
        $this->assertNull($ticket->qr_code);
    }
}

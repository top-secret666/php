<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Ticket;

class TicketsIndexShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_tickets_index_loads()
    {
        Ticket::factory()->create();

        $response = $this->get(route('tickets.index'));

        $response->assertStatus(200);
    }

    public function test_ticket_show_loads()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->get(route('tickets.show', $ticket));

        $response->assertStatus(200);
    }
}

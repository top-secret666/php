<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Ticket;
use App\Models\User;

class TicketsIndexShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_tickets_index_loads()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Ticket::factory()->create();

        $response = $this->actingAs($admin)->get(route('tickets.index'));

        $response->assertStatus(200);
    }

    public function test_ticket_show_loads()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create(['purchaser_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tickets.show', $ticket));

        $response->assertStatus(200);
    }
}

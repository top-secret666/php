<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User, Ticket};
use Illuminate\Support\Carbon;

class TicketCheckInTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_can_be_checked_in_via_update()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'status' => 'sold',
            'purchaser_id' => $user->id,
        ]);

        $checkedInAt = Carbon::now();

        $response = $this->actingAs($user)->put(route('tickets.update', $ticket), [
            'performance_id' => $ticket->performance_id,
            'seat_id' => $ticket->seat_id,
            'status' => 'sold',
            'checked_in_at' => $checkedInAt->toDateTimeString(),
        ]);

        $response->assertStatus(302);

        $ticket->refresh();
        $this->assertNotNull($ticket->checked_in_at);
        $this->assertEquals($checkedInAt->format('Y-m-d H:i:s'), $ticket->checked_in_at->format('Y-m-d H:i:s'));
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User, Show, Order, Performance, Ticket};

class UpdateValidationFailuresTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_show_update_requires_title()
    {
        $admin = $this->makeAdmin();
        $show = Show::factory()->create();

        $response = $this->actingAs($admin)->put(route('shows.update', $show), [
            'title' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title']);
    }

    public function test_order_update_requires_total_amount()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('orders.update', $order), [
            'user_id' => $user->id,
            'total_amount' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['total_amount']);
    }

    public function test_performance_update_requires_show_id()
    {
        $performance = Performance::factory()->create();

        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->put(route('performances.update', $performance), [
            'show_id' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['show_id']);
    }

    public function test_ticket_update_requires_performance_and_seat()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create(['purchaser_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('tickets.update', $ticket), [
            'performance_id' => null,
            'seat_id' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['performance_id', 'seat_id']);
    }
}

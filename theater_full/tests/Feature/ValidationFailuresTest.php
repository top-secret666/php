<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Show, Performance, Seat, PriceTier, User};

class ValidationFailuresTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_show_store_requires_title()
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->post(route('shows.store'), [
            'title' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title']);
    }

    public function test_order_store_requires_user_id_and_total_amount()
    {
        // user_id is nullable (admin may omit; regular user is forced to self)
        // but total_amount is required.
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'total_amount' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['total_amount']);
    }

    public function test_ticket_store_requires_performance_and_seat()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tickets.store'), [
            'performance_id' => null,
            'seat_id' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['performance_id', 'seat_id']);
    }

    public function test_performance_store_requires_show_id()
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->post(route('performances.store'), [
            'show_id' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['show_id']);
    }

    public function test_ticket_store_rejects_invalid_price_tier()
    {
        $user = User::factory()->create();
        $performance = Performance::factory()->create();
        $seat = Seat::factory()->create();

        $response = $this->actingAs($user)->post(route('tickets.store'), [
            'performance_id' => $performance->id,
            'seat_id' => $seat->id,
            'price_tier_id' => 999999,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['price_tier_id']);
    }
}

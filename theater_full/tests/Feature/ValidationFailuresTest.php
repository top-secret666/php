<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Show, Performance, Seat, PriceTier, User};

class ValidationFailuresTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_store_requires_title()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('shows.store'), [
            'title' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title']);
    }

    public function test_order_store_requires_user_id_and_total_amount()
    {
        $response = $this->post(route('orders.store'), [
            'user_id' => null,
            'total_amount' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['user_id', 'total_amount']);
    }

    public function test_ticket_store_requires_performance_and_seat()
    {
        $response = $this->post(route('tickets.store'), [
            'performance_id' => null,
            'seat_id' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['performance_id', 'seat_id']);
    }

    public function test_performance_store_requires_show_id()
    {
        $response = $this->post(route('performances.store'), [
            'show_id' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['show_id']);
    }

    public function test_ticket_store_rejects_invalid_price_tier()
    {
        $performance = Performance::factory()->create();
        $seat = Seat::factory()->create();

        $response = $this->post(route('tickets.store'), [
            'performance_id' => $performance->id,
            'seat_id' => $seat->id,
            'price_tier_id' => 999999,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['price_tier_id']);
    }
}

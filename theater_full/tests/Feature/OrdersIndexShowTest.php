<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\User;

class OrdersIndexShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_orders_index_loads()
    {
        $user = User::factory()->create();
        Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('orders.index'));

        $response->assertStatus(200);
    }

    public function test_order_show_loads()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('orders.show', $order));

        $response->assertStatus(200);
    }
}

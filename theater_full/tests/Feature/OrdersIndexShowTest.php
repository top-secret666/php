<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;

class OrdersIndexShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_orders_index_loads()
    {
        Order::factory()->create();

        $response = $this->get(route('orders.index'));

        $response->assertStatus(200);
    }

    public function test_order_show_loads()
    {
        $order = Order::factory()->create();

        $response = $this->get(route('orders.show', $order));

        $response->assertStatus(200);
    }
}

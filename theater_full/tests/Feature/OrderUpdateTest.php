<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User, Order};

class OrderUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'total_amount' => 10.00,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->put(route('orders.update', $order), [
            'user_id' => $user->id,
            'total_amount' => 25.50,
            'status' => 'paid',
        ]);

        $response->assertStatus(302);

        $order->refresh();
        $this->assertEquals(25.50, (float) $order->total_amount);
        $this->assertEquals('paid', $order->status);
    }
}

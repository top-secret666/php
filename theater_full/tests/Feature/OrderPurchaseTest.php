<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderPurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_order()
    {
        $user = User::factory()->create();


        $response = $this->actingAs($user)->post(route('orders.store'), [
            'user_id' => $user->id,
            'total_amount' => 50.00,
            'status' => 'pending',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_amount' => 50.00,
            'status' => 'pending',
        ]);
    }
}

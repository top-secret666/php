<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User,Performance,Seat,PriceTier,Ticket,Order};

class OrderTicketFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_reserve_then_purchase_ticket_and_issue_qr()
    {
        $user = User::factory()->create();
        $performance = Performance::factory()->create();
        $seat = Seat::factory()->create();
        $price = PriceTier::factory()->create(['venue_id' => $performance->show->venue_id ?? null]);

        // reserve a ticket (status reserved)
        $reserveResponse = $this->actingAs($user)->post(route('tickets.store'), [
            'performance_id' => $performance->id,
            'seat_id' => $seat->id,
            'price_tier_id' => $price->id,
            'status' => 'reserved',
        ]);

        $reserveResponse->assertStatus(302);

        $ticket = Ticket::first();
        $this->assertNotNull($ticket);
        $this->assertEquals('reserved', $ticket->status);

        // create an order to purchase
        $orderResponse = $this->actingAs($user)->post(route('orders.store'), [
            'user_id' => $user->id,
            'total_amount' => 25.00,
            'status' => 'pending',
        ]);
        $orderResponse->assertStatus(302);

        $order = Order::first();
        $this->assertNotNull($order);

        // attach ticket to order and mark sold via ticket update
        $updateResponse = $this->actingAs($user)->put(route('tickets.update', $ticket), [
            'performance_id' => $ticket->performance_id,
            'seat_id' => $ticket->seat_id,
            'price_tier_id' => $ticket->price_tier_id,
            'order_id' => $order->id,
            'status' => 'sold',
        ]);
        $updateResponse->assertStatus(302);

        $ticket->refresh();
        $this->assertEquals('sold', $ticket->status);
        $this->assertEquals($order->id, $ticket->order_id);
        $this->assertNotEmpty($ticket->qr_code, 'QR code should be generated when ticket is sold');
    }
}

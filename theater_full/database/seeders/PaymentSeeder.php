<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Payment, Order};

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();
        if ($orders->isEmpty()) {
            return;
        }

        foreach ($orders as $order) {
            Payment::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'provider' => 'test-gateway',
                    'amount' => $order->total_amount ?? 0,
                    'currency' => 'RUB',
                    'status' => 'paid',
                    'transaction_id' => 'txn_'.$order->id,
                    'paid_at' => now(),
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PriceTier;
use App\Models\Venue;

class PriceTierSeeder extends Seeder
{
    public function run(): void
    {
        $venue = Venue::first();
        if (!$venue) return;

        $tiers = [
            ['name' => 'VIP', 'amount_cents' => 5000 * 100, 'currency' => 'RUB', 'description' => 'Лучшие места'],
            ['name' => 'Стандарт', 'amount_cents' => 2000 * 100, 'currency' => 'RUB', 'description' => 'Обычные места'],
            ['name' => 'Балкон', 'amount_cents' => 1200 * 100, 'currency' => 'RUB', 'description' => 'Места на балконе']
        ];

        foreach ($tiers as $t) {
            PriceTier::firstOrCreate(['venue_id' => $venue->id, 'name' => $t['name']], array_merge(['venue_id' => $venue->id], $t));
        }
    }
}

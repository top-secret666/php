<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Actor, Show};

class ActorSeeder extends Seeder
{
    public function run(): void
    {
        $shows = Show::all();
        if ($shows->isEmpty()) {
            return;
        }

        $actors = Actor::factory()->count(12)->create();

        foreach ($actors as $actor) {
            $actorShows = $shows->random(min(3, $shows->count()));
            foreach ($actorShows as $index => $show) {
                $actor->shows()->syncWithoutDetaching([
                    $show->id => [
                        'character_name' => 'Персонаж '.$index,
                        'billing_order' => $index + 1,
                    ],
                ]);
            }
        }
    }
}

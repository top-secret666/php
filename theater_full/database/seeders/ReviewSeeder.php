<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Review, Show, User};

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $shows = Show::all();

        if ($users->isEmpty() || $shows->isEmpty()) {
            return;
        }

        foreach ($shows as $show) {
            $reviewers = $users->random(min(5, $users->count()));
            foreach ($reviewers as $user) {
                Review::firstOrCreate(
                    ['user_id' => $user->id, 'show_id' => $show->id],
                    ['rating' => rand(3, 5), 'comment' => 'Отличный спектакль!']
                );
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Performance;
use App\Models\Show;
use Carbon\Carbon;

class PerformanceSeeder extends Seeder
{
    public function run(): void
    {
        $shows = Show::all();
        foreach ($shows as $show) {
            // create 3 upcoming performances per show
            for ($i = 1; $i <= 3; $i++) {
                $starts = Carbon::now()->addDays($i * 3)->setTime(19, 0);
                Performance::firstOrCreate(
                    ['show_id' => $show->id, 'starts_at' => $starts],
                    [
                        'ends_at' => $starts->copy()->addMinutes($show->duration_minutes ?? 120),
                        'status' => 'scheduled',
                        'notes' => 'Тестовый показ'
                    ]
                );
            }
        }
    }
}

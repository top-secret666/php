<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Show, Performance};
use App\Models\User;
use Illuminate\Support\Carbon;

class PerformanceCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_performance()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $show = Show::factory()->create();

        $startsAt = Carbon::now()->addDay();

        $response = $this->actingAs($admin)->post(route('performances.store'), [
            'show_id' => $show->id,
            'starts_at' => $startsAt->toDateTimeString(),
            'status' => 'scheduled',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('performances', [
            'show_id' => $show->id,
            'status' => 'scheduled',
        ]);

        $this->assertNotNull(Performance::first());
    }
}

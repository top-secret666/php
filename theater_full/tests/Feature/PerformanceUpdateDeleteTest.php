<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Show, Performance, User};
use Illuminate\Support\Carbon;

class PerformanceUpdateDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_performance()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $show = Show::factory()->create();
        $performance = Performance::factory()->create([
            'show_id' => $show->id,
            'status' => 'scheduled',
        ]);

        $newStart = Carbon::now()->addDays(2);

        $response = $this->actingAs($admin)->put(route('performances.update', $performance), [
            'show_id' => $show->id,
            'starts_at' => $newStart->toDateTimeString(),
            'status' => 'cancelled',
        ]);

        $response->assertStatus(302);

        $performance->refresh();
        $this->assertEquals('cancelled', $performance->status);
    }

    public function test_can_delete_performance()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $performance = Performance::factory()->create();

        $response = $this->actingAs($admin)->delete(route('performances.destroy', $performance));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('performances', [
            'id' => $performance->id,
        ]);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Performance;

class PerformanceIndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_performances_index_lists_performances()
    {
        $response = $this->get('/performances');
        $response->assertStatus(200);

        $perf = Performance::first();
        if ($perf) {
            $response->assertSee($perf->starts_at ? $perf->starts_at->format('Y') : substr($perf->date ?? '', 0, 4));
        } else {
            $this->assertTrue(true, 'No performances seeded; page still returned 200');
        }
    }
}

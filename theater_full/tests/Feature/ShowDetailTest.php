<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Show;

class ShowDetailTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_show_detail_page_shows_title()
    {
        $show = Show::first();
        $this->assertNotNull($show, 'No shows seeded for test data');

        $response = $this->get(route('shows.show', $show));
        $response->assertStatus(200);
        $response->assertSee($show->title);
    }
}

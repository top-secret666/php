<?php

namespace Tests\Feature;

use App\Models\Show;
use App\Models\Venue;
use Tests\TestCase;

class ShowsFilterSortTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_can_search_shows_by_query_and_sort_results()
    {
        $venue = Venue::first() ?? Venue::factory()->create();

        Show::create([
            'title' => 'FILTERTEST Alpha',
            'director' => 'DirOne',
            'description' => 'FILTERTEST description',
            'duration_minutes' => 100,
            'language' => 'ru',
            'age_rating' => '12+',
            'venue_id' => $venue->id,
        ]);

        Show::create([
            'title' => 'FILTERTEST Beta',
            'director' => 'DirTwo',
            'description' => 'FILTERTEST description',
            'duration_minutes' => 90,
            'language' => 'ru',
            'age_rating' => '12+',
            'venue_id' => $venue->id,
        ]);

        $response = $this->get('/shows/search?q=FILTERTEST&sort=title&dir=asc');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['FILTERTEST Alpha', 'FILTERTEST Beta']);
    }

    public function test_can_filter_shows_by_exact_director()
    {
        $venue = Venue::first() ?? Venue::factory()->create();

        Show::create([
            'title' => 'FILTERTEST Director A',
            'director' => 'Director A',
            'description' => 'FILTERTEST description',
            'duration_minutes' => 100,
            'language' => 'ru',
            'age_rating' => '12+',
            'venue_id' => $venue->id,
        ]);

        Show::create([
            'title' => 'FILTERTEST Director B',
            'director' => 'Director B',
            'description' => 'FILTERTEST description',
            'duration_minutes' => 100,
            'language' => 'ru',
            'age_rating' => '12+',
            'venue_id' => $venue->id,
        ]);

        $response = $this->get('/shows/search?q=FILTERTEST&director=' . urlencode('Director B'));
        $response->assertStatus(200);
        $response->assertSee('FILTERTEST Director B');
        $response->assertDontSee('FILTERTEST Director A');
    }
}

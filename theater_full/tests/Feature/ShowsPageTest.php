<?php

namespace Tests\Feature;

use Tests\TestCase;

class ShowsPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Ensure fresh DB with seeds for predictable test data
        $this->artisan('migrate:fresh --seed');
    }

    public function test_homepage_shows_poster_list()
    {
        // some setups redirect the root (302) — follow redirects to assert final page content
        $response = $this->followingRedirects()->get('/');
        $response->assertStatus(200);
        $response->assertSee('Афиша спектаклей');
    }

    public function test_shows_index_page_lists_shows()
    {
        $response = $this->get('/shows');
        $response->assertStatus(200);
        // Expect at least one seeded show (e.g. "Ревизор")
        $response->assertSee('Ревизор');
    }
}

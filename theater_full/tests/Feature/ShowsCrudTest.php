<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Show;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Support\Facades\Hash;

class ShowsCrudTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_index_shows_list()
    {
        $response = $this->get(route('shows.index'));
        $response->assertStatus(200);
        $this->assertNotEmpty(Show::all());
    }

    public function test_guest_cannot_access_create()
    {
        $response = $this->get(route('shows.create'));
        $response->assertStatus(302);
    }

    public function test_authenticated_user_can_create_show()
    {
        $user = User::create([
            'name' => 'Creator',
            'email' => 'creator+' . time() . '@example.test',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $venue = Venue::first();
        $payload = [
            'title' => 'Test Show ' . time(),
            'description' => 'A test description',
            'duration_minutes' => 90,
            'language' => 'ru',
            'age_rating' => '12+',
            'venue_id' => $venue ? $venue->id : null,
        ];

        $response = $this->actingAs($user)->post(route('shows.store'), $payload);
        $response->assertStatus(302);

        $this->assertDatabaseHas('shows', ['title' => $payload['title']]);
    }

    public function test_authenticated_user_can_edit_show()
    {
        $user = User::create([
            'name' => 'Editor',
            'email' => 'editor+' . time() . '@example.test',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $show = Show::first();
        $this->assertNotNull($show);

        $response = $this->actingAs($user)->get(route('shows.edit', $show));
        $response->assertStatus(200);

        $newTitle = $show->title . ' (edited)';
        $response = $this->actingAs($user)->put(route('shows.update', $show), [
            'title' => $newTitle,
            'description' => $show->description,
            'duration_minutes' => $show->duration_minutes ?? 90,
            'language' => $show->language ?? 'ru',
            'age_rating' => $show->age_rating ?? '0+',
            'venue_id' => $show->venue_id,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('shows', ['title' => $newTitle]);
    }

    public function test_authenticated_user_can_delete_show()
    {
        $user = User::create([
            'name' => 'Remover',
            'email' => 'remover+' . time() . '@example.test',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $show = Show::create([
            'title' => 'To delete ' . time(),
            'description' => 'delete me',
            'duration_minutes' => 60,
            'language' => 'ru',
            'age_rating' => '0+',
            'venue_id' => Venue::first()->id ?? null,
        ]);

        $response = $this->actingAs($user)->delete(route('shows.destroy', $show));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('shows', ['id' => $show->id]);
    }
}

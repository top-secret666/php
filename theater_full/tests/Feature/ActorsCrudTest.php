<?php

namespace Tests\Feature;

use App\Models\Actor;
use App\Models\Show;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ActorsCrudTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_actors_index_loads_for_guest()
    {
        $response = $this->get(route('actors.index'));
        $response->assertStatus(200);
        $response->assertSee('Актёры');
    }

    public function test_guest_cannot_access_actor_create_form()
    {
        $response = $this->get(route('actors.create'));
        $response->assertStatus(302);
    }

    public function test_authenticated_user_can_create_actor_with_role_and_show()
    {
        $user = User::create([
            'name' => 'Actor Admin',
            'email' => 'actor-admin+' . time() . '@example.test',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $show = Show::first();
        $this->assertNotNull($show);

        $payload = [
            'full_name' => 'Test Actor ' . time(),
            'bio' => 'Bio',
            'birth_date' => '1990-01-01',
            'show_id' => $show->id,
            'character_name' => 'Hamlet',
        ];

        $response = $this->actingAs($user)->post(route('actors.store'), $payload);
        $response->assertStatus(302);

        $this->assertDatabaseHas('actors', ['full_name' => $payload['full_name']]);

        $actor = Actor::where('full_name', $payload['full_name'])->first();
        $this->assertNotNull($actor);

        $this->assertDatabaseHas('actor_show', [
            'actor_id' => $actor->id,
            'show_id' => $show->id,
            'character_name' => 'Hamlet',
        ]);
    }
}

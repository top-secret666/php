<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShowPosterUploadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_authenticated_user_can_upload_poster_for_show()
    {
        Storage::fake('public');

        $user = User::create([
            'name' => 'Uploader',
            'email' => 'uploader+' . time() . '@example.test',
            'password' => Hash::make('password'),
        ]);

        $venue = Venue::first();

        $payload = [
            'title' => 'Poster Upload Show ' . time(),
            'director' => 'Director',
            'description' => 'desc',
            'duration_minutes' => 120,
            'language' => 'ru',
            'age_rating' => '12+',
            'venue_id' => $venue ? $venue->id : null,
            // Use a generic fake file to avoid requiring GD in the test runtime.
            'poster' => UploadedFile::fake()->create('poster.jpg', 120, 'image/jpeg'),
        ];

        $response = $this->actingAs($user)->post(route('shows.store'), $payload);
        $response->assertStatus(302);

        $this->assertDatabaseHas('shows', ['title' => $payload['title']]);

        $show = \App\Models\Show::where('title', $payload['title'])->first();
        $this->assertNotNull($show);
        $this->assertNotEmpty($show->poster_url);

        // Stored on the public disk under posters/
        Storage::disk('public')->assertExists(str_replace('/storage/', '', $show->poster_url));
    }
}

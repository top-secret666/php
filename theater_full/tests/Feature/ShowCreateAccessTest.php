<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ShowCreateAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_guest_cannot_access_create_form()
    {
        $response = $this->get('/shows/create');
        $response->assertStatus(302); // redirect to login
    }

    public function test_authenticated_user_can_access_create_form()
    {
        // Some projects don't use HasFactory on User in this scaffold; create manually
        $user = User::create([
            'name' => 'Tester',
            'email' => 'tester+' . time() . '@example.test',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->get('/shows/create');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_create_form()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin+' . time() . '@example.test',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/shows/create');
        $response->assertStatus(200);
    }
}

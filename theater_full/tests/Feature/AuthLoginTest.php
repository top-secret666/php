<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $email = 'login+' . time() . '@example.test';

        $user = User::create([
            'name' => 'Login User',
            'email' => $email,
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->post('/login', [
            'email' => $email,
            'password' => 'secret123',
        ]);

        // Should redirect after successful login
        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $email = 'login+' . time() . '@example.test';

        $user = User::create([
            'name' => 'Login User',
            'email' => $email,
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $email,
            'password' => 'wrong',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}

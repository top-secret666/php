<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthRegisterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_user_can_register()
    {
        $email = 'testuser+' . time() . '@example.test';
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => $email]);
    }
}

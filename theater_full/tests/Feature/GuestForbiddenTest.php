<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuestForbiddenTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_forbidden_on_admin_dashboard()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }
}

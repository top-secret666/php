<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminStatsPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function test_admin_can_view_stats_page()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin-stats+' . time() . '@example.test',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.stats.index'));
        $response->assertStatus(200);
        $response->assertSee('Статистика посещаемости');
    }

    public function test_guest_cannot_view_stats_page()
    {
        $response = $this->get(route('admin.stats.index'));
        $response->assertStatus(403);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/');
    }

    public function test_admin_can_access_dashboard_and_admins_index(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/dashboard')->assertStatus(200);
        $this->actingAs($admin)->get('/admins')->assertStatus(200);
    }

    public function test_mechanic_can_access_dashboard_but_not_admins_index(): void
    {
        $mechanic = User::factory()->create(['role' => 'mekanik']);

        $this->actingAs($mechanic)->get('/dashboard')->assertStatus(200);
        $this->actingAs($mechanic)->get('/admins')->assertStatus(403);
    }
}

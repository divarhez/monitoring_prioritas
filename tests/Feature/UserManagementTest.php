<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    public function test_admin_can_view_users_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/users');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->post('/users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'user',
        ]);
        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_admin_can_edit_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $response = $this->actingAs($admin)->put("/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => $user->email,
            'role' => 'user',
        ]);
        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
    }

    public function test_admin_can_delete_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $response = $this->actingAs($admin)->delete("/users/{$user->id}");
        $response->assertRedirect('/users');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_non_admin_cannot_view_users_page()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get('/users');
        $response->assertStatus(403);
    }
}

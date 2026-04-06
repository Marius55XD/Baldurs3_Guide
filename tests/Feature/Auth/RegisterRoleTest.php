<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_special_admin_credentials_create_an_admin_user(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Admin',
            'email' => 'admin@bg3guide.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'email' => 'admin@bg3guide.com',
            'role' => 'admin',
        ]);

        $user = User::where('email', 'admin@bg3guide.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->isAdmin());
    }

    public function test_normal_registration_creates_a_user_role_account(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Player',
            'email' => 'player@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'email' => 'player@example.com',
            'role' => 'user',
        ]);
    }
}

<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_special_admin_credentials_create_an_admin_user(): void
    {
        Notification::fake();

        $response = $this->from('/register')->post('/register', [
            'name' => 'Admin',
            'email' => 'admin@bg3guide.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('verification.notice'));

        $this->assertDatabaseHas('users', [
            'email' => 'admin@bg3guide.com',
            'role' => 'admin',
        ]);

        $user = User::where('email', 'admin@bg3guide.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->hasVerifiedEmail());

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_normal_registration_creates_a_user_role_account(): void
    {
        Notification::fake();

        $response = $this->from('/register')->post('/register', [
            'name' => 'Player',
            'email' => 'player@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('verification.notice'));

        $this->assertDatabaseHas('users', [
            'email' => 'player@example.com',
            'role' => 'user',
        ]);

        $user = User::where('email', 'player@example.com')->first();
        $this->assertNotNull($user);
        $this->assertFalse($user->hasVerifiedEmail());

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}

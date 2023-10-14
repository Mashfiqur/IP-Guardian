<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthenticationUnitTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::create([
            'name'      => 'Unit Test User',
            'email'     => 'unit_test@example.com',
            'password'  => 'unit_password',
        ]);
    }

    public function test_user_cannot_login_with_non_existing_email()
    {
        $response = $this->postJson(config('test.urls.auth.login'), [
            'email' => 'non_existing_email@example.com',
            'password' => 'unit_password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_user_cannot_login_with_invalid_password()
    {
        $response = $this->postJson(config('test.urls.auth.login'), [
            'email' => 'unit_test@example.com',
            'password' => 'invalid_password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_log_entry_is_created_when_user_logs_in()
    {
        $this->postJson(config('test.urls.auth.login'), [
            'email'     => 'unit_test@example.com',
            'password'  => 'unit_password',
        ]);

        $this->assertDatabaseHas('authentication_logs', [
            'user_id' => $this->user->id,
            'login_at' => now()->toDateTimeString()
        ]);
    }

    public function test_log_is_updated_when_user_logs_out()
    {
        $token = $this->user->createToken('test-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer $token")->postJson(config('test.urls.auth.logout'));

        $this->assertDatabaseHas('authentication_logs', [
            'user_id' => $this->user->id,
            'logout_at' => now()->toDateTimeString()
        ]);
    }

    public function test_personal_access_token_is_deleted_when_user_logs_out()
    {
        $token = $this->user->createToken('test-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer $token")->postJson(config('test.urls.auth.logout'));

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $this->user->id,
            'name' => 'test-token',
        ]);
    }
}

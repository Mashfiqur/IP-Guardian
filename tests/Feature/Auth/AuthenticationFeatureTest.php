<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::create([
            'name'      => 'Test User',
            'email'     => 'test@example.com',
            'password'  => 'password',
        ]);
    }

    public function test_user_can_login()
    {
        $response = $this->postJson(config('test.urls.auth.login'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_authrozied_user_can_logout()
    {
        $token = $this->user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")->postJson(config('test.urls.auth.logout'));

        $response->assertStatus(200)
            ->assertJson(['message' => 'You have successfully logged out']);
    }

    public function test_unauthrozied_user_cannot_logout()
    {
        $response = $this->postJson(config('test.urls.auth.logout'));

        $response->assertStatus(401)
            ->assertJsonStructure(['message']);
    }
}

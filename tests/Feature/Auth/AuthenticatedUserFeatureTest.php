<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticatedUserFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_access_information()
    {
        $user = User::factory()->create();
        
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")->getJson(config('test.urls.auth.authenticate'));

        $response->assertStatus(200);

        $response->assertJsonStructure(['user' => ['id', 'name', 'email']]);
    }

    public function test_unauthenticated_user_cannot_access_information()
    {
        $response = $this->withHeader('Authorization', "Bearer unauthenticated_token")->getJson(config('test.urls.auth.authenticate'));

        $response->assertStatus(401);

        $response->assertJsonStructure(['message']);
    }
}

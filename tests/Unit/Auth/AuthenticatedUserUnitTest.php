<?php

namespace Tests\Unit\Auth;

use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthenticatedUserUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_access_controller()
    {
        $user = User::factory()->create();
        
        $request = Request::create(config('test.urls.auth.authenticate'), 'GET');

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $controller = new AuthenticatedUserController();

        $response = $controller($request);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(200, $response->getStatusCode());
    }
}

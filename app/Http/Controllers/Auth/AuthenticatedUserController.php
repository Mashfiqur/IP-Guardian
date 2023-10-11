<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserBasicResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticatedUserController extends Controller
{
    /**
     * Get Authorized User information.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        // This controller is responsible for providing information about the authenticated user.

        // We can customize the data that we send to the frontend here, such as:
        // - App configuration settings that are relevant to the user.
        // - User-specific permissions and roles, which can be used to control frontend behavior.
        // - Any other user-specific data needed for bootstrapping frontend settings.

        return response()->json([
            'user' => new UserBasicResource($request->user())
        ]);
    }
}
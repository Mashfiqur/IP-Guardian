<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\User\UserBasicResource;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Get User Profile
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(['data' => new UserBasicResource($request->user())]);
    }

    /**
     * Update User Profile
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $request->user()->update($data);

        return response()->json(['message' => 'You profile has been updated successfully']);
    }
}

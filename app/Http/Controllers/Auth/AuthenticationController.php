<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Logout;

class AuthenticationController extends Controller
{
    /**
     * Handle user login.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        try {
            if (!Auth::attempt($credentials)) {
                throw new AuthenticationException('The credentials do not match our records');
            }

            $user = auth()->user();

            if (!$user->is_active) {
                throw new AuthenticationException('Your account is not active. Please contact support.');
            }

            return response()->json([
                'token' => $user->createToken('web-token')->plainTextToken
            ]);
        } catch (AuthenticationException $e) {
            throw ValidationException::withMessages(['password' => $e->getMessage()]);
        }
    }

    /**
     * Handle user logout.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        event(new Logout('sanctum', auth()->user()));
                    
        return response()->json(['message' => 'You have successfully logged out']);
    }
}

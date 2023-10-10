<?php

namespace App\Actions\Auth;

use App\Models\AuthenticationLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CreateAuthenticationLog
{
    /**
     * Create a new authentication log of the user.
     *
     * @param  \App\Models\User
     * @param  \Illuminate\Http\Request
     * @param  int $type
     * $type: 1 => Login Log, 2 => Logout Log without Login
     * 
     * @return App\Models\AuthenticationLog
     */
    public static function create(User $user, Request $request, int $type = 1): AuthenticationLog
    {
        try {
            $log = [
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ];

            if ($type === 1) {
                $log['login_at'] = Carbon::now();
            } elseif ($type === 2) {
                $log['logout_at'] = Carbon::now();
            }

            return AuthenticationLog::create($log);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

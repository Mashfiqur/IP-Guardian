<?php

namespace App\Actions\Auth;

use App\Models\AuthenticationLog;
use Carbon\Carbon;

class UpdateAuthenticationLog
{
    /**
     * Update authentication log
     *
     * @param  array  $input
     * @return \App\Models\AuthenticationLog
     */
    public static function update(AuthenticationLog $authenticationLog)
    {
        try{
            $authenticationLog->logout_at = Carbon::now();
            return $authenticationLog->save();
        }
        catch(\Exception $e){
            throw $e;
        }
    }
}

<?php

namespace App\Listeners\Auth;

use App\Actions\Auth\CreateAuthenticationLog;
use App\Actions\Auth\UpdateAuthenticationLog;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;

class LogoutSuccessfulListener
{

    /**
     * The request object.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Create the event listener.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * Handle the event.
     *
     * @param  Logout  $event
     *
     * @return void
     */
    public function handle(Logout $event)
    {
        if (!$event->user) {
            return;
        }

        $user = $event->user;
        $ip = $this->request->ip();
        $userAgent = $this->request->userAgent();

        $authenticationLog = $user->authentication_logs()
            ->where([
                ['ip_address', $ip],
                ['user_agent', $userAgent],
            ])
            ->orderByDesc('created_at')
            ->first();

        // Create a new authentication log of the user if not exists without login time
        if (!$authenticationLog) {
            CreateAuthenticationLog::create($event->user, $this->request, 2);
            return;
        }

        UpdateAuthenticationLog::update($authenticationLog);
    }
}

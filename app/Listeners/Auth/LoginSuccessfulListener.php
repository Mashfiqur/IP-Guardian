<?php

namespace App\Listeners\Auth;

use App\Actions\Auth\CreateAuthenticationLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class LoginSuccessfulListener
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
     * @param  Login  $event
     *
     * @return void
     */
    public function handle(Login $event)
    {
        try {
            CreateAuthenticationLog::create($event->user, $this->request);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

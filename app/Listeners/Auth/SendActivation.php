<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserActivation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendActivation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserActivation  $event
     * @return void
     */
    public function handle(UserActivation $event)
    {
        return view('auth.otp', ['user' => $event]);
    }
}

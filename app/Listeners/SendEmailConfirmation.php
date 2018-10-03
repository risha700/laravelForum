<?php

namespace App\Listeners;

use App\Mail\PleaseConfirmYourEmail;
// use App\Providers\Registered;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
class SendEmailConfirmation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
      Mail::to($event->user)->send( new PleaseConfirmYourEmail($event->user) );
    }
}

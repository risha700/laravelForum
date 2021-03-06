<?php

namespace App\Providers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ThreadHasNewReply' => [
            'App\Listeners\NotifyThreadSubscribers',
             'App\Listeners\NotifyMentionedUsers',
        ],

        Registered::class =>[

            'App\Listeners\SendEmailConfirmation',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

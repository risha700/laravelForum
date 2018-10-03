<?php

namespace App\Listeners;
use App\Events\ThreadHasNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Thread;

class NotifyThreadSubscribers
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
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {


        $event->thread->notifySubscribers($event->reply);

       
        // $event->thread->subscription
        // ->where('user_id', '!=', $event->reply->user_id)
        // ->each->notify($event->reply);
    }
}

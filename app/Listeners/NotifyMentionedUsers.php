<?php

namespace App\Listeners;
use \App\User;
use \App\Notifications\YouWereMentioned;
use \App\Events\ThreadHasNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
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
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    // public function handle(ThreadHasNewReply $event)
    // {
    //     // preg_match_all('/\@([^\s\.]+)/', $event->reply->body, $matches);
    //         $mentionedUsers=$event->reply->mentionedUsers();
    //         foreach ($mentionedUsers as $name) {
    //         $user = User::whereName($name)->first();

    //         if($user){
    //         $user->notify(new YouWereMentioned($event->reply));
    //         }
    //     }

    // }

    // another brilliant way
    //  public function handle(ThreadHasNewReply $event)
    // {

    //     collect($event-reply->mentionedUsers())
    //     ->map(function($name){
    //           return User::where('name', $name)->first();
    //     })->filter()
    //     ->each (function($user) use ($event){
    //          $user->notify(new YouWereMentioned($event->reply));


    //     });
           

    // }


    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}

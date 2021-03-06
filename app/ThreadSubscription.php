<?php

namespace App;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
     	 protected $guarded = [
			
    ];



    protected $table = 'thread_subscriptions';
    public function user()
    {
    	return $this->belongsTo(\App\User::class);
    }
        public function thread()
    {
    	return $this->belongsTo(\App\Thread::class);
    }



    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($this, $reply));
    }


    
}

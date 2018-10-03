<?php

namespace App;

use App\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
class Trending extends Model
{
    public function get()
    {
    	return  array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, 4));

    }

    public function addUp($thread)
	{
	    Redis::zincrby('trending_threads', 1, json_encode([

	    'title'=>$thread->title,
	    'path'=> $thread->path(),
	    'id'=> $thread->id

		]));
    	
    }


    public function cacheKey()
    {
    	return 'trending_threads';
    }

    public function reset()
    {
    	Redis::del($this->cacheKey());
    }


    public function thread(){

        return $this->belongsTo(Thread::class);
    }
}

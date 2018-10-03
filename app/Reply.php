<?php

namespace App;
//use App\Inspections\Spam;
use App\Thread;
//use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Stevebauman\Purify\Facades\Purify;

class Reply extends Model
{
  use Favoritable;
  use RecordsActivity;




	 protected $fillable = [
        'body','user_id'
    ];

    protected $with = ['user'];



    protected $appends = ['is_favorited','favorites_count', 'is_best', 'thread_owner'];





    protected static function boot()
    {
      parent::boot();

      static::created(function($reply){

            $reply->thread->increment('reply_count');
      });


      static::deleted(function($reply){

            if($reply->isBest()){

              $reply->thread->update(['best_reply_id'=> null]);
            }


            $reply->thread->decrement('reply_count');
      });


    }




    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

   public function user(){

   	return $this->belongsTo(User::class, 'user_id');
   }


//
//   public function favorites(){
//
//    return $this->belongsTo(Favorite::class, 'favorited_id');
////     ->toJson();
//
////     return $this->morphTo();
//   }

// this prevents the static delete method
   // public function activity(){

   //  return $this->belongsTo(Activity::class);
   //  // return $this->morphTo();
   // }

   public  function path()
   {
     return $this->thread->path() ."#reply-{$this->id}" ;
   }


   public function wasJustPublished()
   {
     
     return !! $this->created_at->gt(Carbon::now()->subMinute());
   }

   public function mentionedUsers()
   {
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);
        return $matches[1];
   }
    /**
     * Set the body attribute.
     *
     * @param string $body
     */
    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            '<a href="/profile/$1">$0</a>',
            $body
        );
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function isBest()
    {
        return $this->thread()->where('best_reply_id', $this->id)->exists();
//        return $this->thread->where('best_reply_id' , $this->id)->get();
//       return ! $this->thread->best_reply_id == $this->id;
//        return $this->thread->best_reply_id == $this->id;


    }

    public function getThreadOwnerAttribute()
    {
       return $this->thread()->where('user_id', auth()->id())->exists();
//        return $this->thread->where('user_id', auth()->id())->exists();

//         return $this->thread->user->id == $this->id;
    }




    public function getBodyAttribute($body)
    {

        return Purify::clean($body);

    }


}

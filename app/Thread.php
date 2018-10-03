<?php

namespace App;

use \App\ThreadSubscription;
use \App\Events\ThreadHasNewReply;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Stevebauman\Purify\Facades\Purify;

class Thread extends Model
{


    use RecordsActivity, Favoritable, Searchable;

	    protected $fillable = [
        'body', 'title', 'user_id','channel_id', 'slug', 'best_reply_id', 'locked'
            ];


    protected $table = 'threads';

        protected $with = ['user','reply','channel'];

        
        protected $appends = ['is_subscribed_to','is_favorited','favorites_count'];

//        protected $cast = [
//            'is_subscribed_to'=>'boolean'
//        ];


        protected static function boot(){

        parent::boot();


        // instead of eagerloading we added a reply_count column on threads    


        // static::addGlobalScope('replyCount', function($builder){

        //     $builder->withCount('reply');
        // });





 
        static::deleting(function($thread){

                $thread->reply->each->delete();
                
            }); 



            // $thread->reply->each(function($reply){

            //     $reply->delete();

            // }); 

            //  $thread->activity->each(function($activity){

            //     $activity->delete();

            // }); 

        // });
    }

//    public function favorite(){
//
//        return $this->belongsTo(Favorite::class);
//        //replaced with favoritesCount attribute on favoritable
//        // ->withCount('favorites');
//    }


    public function path(){

        return '/threads/'.$this->channel->slug.'/' . $this->slug;
    }


    public function reply(){

    	return $this->hasMany(Reply::class);
        //replaced with favoritesCount attribute on favoritable
        // ->withCount('favorites');
    }

    

    public function user (){
    	return $this->belongsTo(User::class, 'user_id');
    }



    public function channel (){
    return $this->belongsTo(Channel::class);
    }



    // public function addReply($reply){

    // 	return $this->reply()->create($reply);
    // }

// an option to retrieve the column and increment reply_count or use model events "static on reply"
    public function addReply($reply){

        $reply= $this->reply()->create($reply);


        // $this->notifySubscribers($reply);

        // the event is already benn set but we used notify subscribers on thread

        event(new ThreadHasNewReply($this, $reply));




        // $this->subscription
        // ->where('user_id', '!=', $reply->user_id)



        // ->filter(function ($sub) use ($reply){

        //     return $sub->user_id != $reply->user_id;
        // })

        // use higher order collections

        // ->each->notify($reply);



        // ->each(function ($sub) use ($reply){
        //     $sub->user->notify(new ThreadWasUpdated($this, $reply));
        // });


        // $this->increment('reply_count');

        // or for subscriptions
        // foreach ($this->subscription as $sub) {

        //     if($sub->user_id != $reply->user_id){
        //    $sub->user->notify(new ThreadWasUpdated($this, $reply));
        //    }
        // }
        return $reply;
    }

        public function getRouteKeyName()
    {
        return 'slug';
    }



    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {

// normally attach the unique id to prevent deuplications
            // $slug = "{$slug}-{$this->id}";
//let's do it the other way
        $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }





   public function incrementSlug($slug)
    {

        $max = static::whereTitle($this->title)->latest('id')->value('slug');

        if (is_numeric(substr($max, -1))) {
            return preg_replace_callback('/(\d+)$/', function ($matches) {
                return $matches[1] + 1;
            }, $max);
        }

        return "{$slug}-2";
    }




    public function notifySubscribers($reply)
    {


         $this->subscription
        ->where('user_id', '!=', $reply->user_id)
        ->each
        ->notify($reply);




    }
    public function getReplyCountAttribute(){

        return $this->reply->count();
    }

//     public function favorite()
//
//     {
////         return $this->morphMany(Favorite::class,'favorited_id');
////        return $this->morphTo();
//     }

    public function ScopeFilter($query, $filters){

        return $filters->apply($query);
    }


    public function subscribe($userId = null)
    {
        $this->subscription()->create([
                    'user_id'=> $userId ?: auth()->id()
                ]);
        return $this;
    }

    public function subscription()
    {
         return $this->hasMany(ThreadSubscription::class);
    }

    public function unsubscribe($userId = null)
    {
         $this->subscription()->where([ 'user_id'=> $userId ?: auth()->id()])->delete();
    }



    public function getIsSubscribedToAttribute()
    {
        
        return $this->subscription()->where('user_id', auth()->id())->exists();
    }




    public function hasUpdatesFor()
    {

        $key = sprintf('users.%s.visits.%s' , auth()->id(), $this->id);
        return $this->updated_at-> cache($key);
    }






    public function recordVisits()
    {
        Redis::incr($this->cacheKey());
        return $this;
    }

    public function visits()
    {
        return Redis::get($this->cacheKey());
    }

    public function resetVisits()
    {
          Redis::del($this->cacheKey());
          return $this;
    }

    public function cacheKey()
    {
        return "thread.{$this->id}.visits";
        
    }

    public function lock()
    {

         $this->update(['locked'=>true]);

    }
    public function unlock()
    {

         $this->update(['locked'=>false]);

    }
//export a produced column from the class to angolina
    public function toSearchableArray()
    {
        return $this->toArray()+ ['path'=>$this->path()];
    }

//sanitize with "stevebauman/purify": "2.0.*"

    public function getBodyAttribute($body)
    {

        return Purify::clean($body);

    }


}

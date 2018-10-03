<?php

namespace App;


//use App\Thread;
//use App\Reply;
//use App\Favorite;
//use App\Activity;
use Illuminate\Database\Eloquent\Model;



class Favorite extends Model
{
	use RecordsActivity;

   	 protected $guarded = [];

//     protected static function boot(){
//         parent::boot();
//        static::deleting(function($favorited){
//
//
//              $favorited->activity->each(function($activity){
//
//                 $activity->delete();
//
//             });
//
//       });
//     }
//
//    protected $with = ['reply', 'thread'];
//
//
//     public function thread(){
//
//     	return $this->belongsTo(Thread::class,'favorited_id');
//     }
//
//
//    public function reply(){
//
//    	return $this->belongsTo(Reply::class,'favorited_id');
//        // return $this->morphTo();
//    }
//
//         public function activity(){
//
//         return $this->belongsTo(Activity::class,'subject_id');
//         // return $this->morphTo();
//     }

    public function favorited()

    {
        // return $this->belongsTo(Favorite::class,'subject_id');
      return $this->morphTo();
    }



}

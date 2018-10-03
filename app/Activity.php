<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    use Favoritable;

    protected $guarded=[];


    public function subject(){


    	return $this->morphTo();
    }

    public function user(){

    	return $this->belongsTo(User::class);
    }


    // public function favorite(){

    //     return $this->hasMany(Favorite::class);
    //     // return $this->morphTo();

    // }
    

    public static function feed($user, $take = 30){

			return static::where('user_id', $user->id)
			->latest()
			->with('subject')
			->take($take)->get()
			->groupBy( function($activity){
            return $activity->created_at->format('Y-m-d');
           });


    }

}

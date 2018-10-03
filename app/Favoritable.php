<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
trait Favoritable

{

  protected static function bootFavoritable(){




        static::deleting(function($model){

            $model->favorites->each->delete();


        });




    }





    /**
     * A reply can be favorited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }




   public function favorite(){


   	$attributes = ['user_id'=>auth()->id()];

    if(! $this->favorites()->create(['user_id'=>auth()->id()])->exists()){


    	return $this->favorites()->create($attributes);


    }
   }

   public function isFavorited(){

      return  !! $this->favorites->where('user_id', auth()->id() )->count();

   }

   public function unfavorite()
   {
      $attributes = ['user_id'=>auth()->id()];




      // this way you delete with normal query

      // $this->favorites()->where($attributes)->delete();



      // this way you request instance of a model and delete all of them

       // $this->favorites()->where($attributes)->get()->each(function($favorite){

       //    $favorite->delete();

       // });

       //this is higer collection shortcut


        $this->favorites()->where($attributes)->get()->each->delete();
   }

    public function getFavoritesCountAttribute()
    {
      return $this->favorites->count();
    }




    public function getIsFavoritedAttribute()
    {
//     return  $this->favorites->where('user_id', auth()->id() )->count();
        return $this->isFavorited();


    }






}
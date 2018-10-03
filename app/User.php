<?php

namespace App;
use App\Thread;
//use App\Activity;
use App\Reply;
//use App\Favorite;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use RecordsActivity;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path', 'confirmed', 'confirmation_token'
    ];
   
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email',
    ];


    protected $casts=[

        'confirmed'=>'boolean',
        'is_admin'=>'boolean'
    ];


    protected $appends = ['is_admin'];




    public function threads(){

        return $this->hasMany(Thread::class)->latest();
    }

//    public function reply(){
//
//        return $this->hasMany(Reply::class);
//    }
// morphMany
    public function activity(){
        
        return $this->hasMany(Activity::class);
    }
//
//    public function favorite(){
//
//        return $this->hasMany(Favorite::class);
//    }


    public function getRouteKeyName()
    {
        return 'name';
    }

    public function read($thread)
    {
     cache()->forever($this->visitedThreadCacheKey($thread), \Carbon\Carbon::now());
    }

    public function confirmed()
    {
        $this->confirmed = true;
        $this->confirmation_token = NULL;
        $this->save();
    }


    public function visitedThreadCacheKey($thread)
    {
    return sprintf('users.%s.visits.%s' , auth()->id(), $thread->id);
    }


    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    // public function avatar()
    // {
    //     return asset($this->avatar_path ?: '/img/defaultAvatar.png');
    // }

    
        public function getAvatarPathAttribute($avatar)
    {


        return asset($avatar ?: '/img/defaultAvatar.png');

    }

    public function isAdmin(){

        if(auth()->check()){
        return in_array(auth()->user()->name, ['Risha']);
        }
    }

    public function getIsAdminAttribute()
    {
        return  $this->isAdmin();

    }


}

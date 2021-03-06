<?php

namespace App\Policies;

use App\User;
// use App\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }



        public function update(User $user, User $signedInUser)
    {
       return $signedInUser->id === $user->id;
    }

}

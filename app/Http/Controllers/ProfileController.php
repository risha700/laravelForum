<?php

namespace App\Http\Controllers;
use App\User;
use App\Activity;
use App\Thread;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

      public function __construct(){

        return $this->middleware('auth');
        // ->only(['create','store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Thread $thread, Activity $activity)
    {


//           $activities = $user->activity()->latest()->with('subject')->get()->groupBy('subject_type');
//           $activities = Activity::feed($user);
//           dd($activity);

//            return $activities;
//if($activities->subject->thread) {
//    return $activities->subject->thread->title;
//}
//
//    return $activities->subject->reply->title;



//           return $thread;











        return view('profiles.index', [

                'profileUser'=>$user,
                // 'thread'=>$user->threads()->get(),
                // 'activities'=>$this->getActivity($user),
                'activities'=>Activity::feed($user)

            ]);
    }
}
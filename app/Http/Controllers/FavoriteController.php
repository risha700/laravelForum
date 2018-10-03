<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Reply;
use Illuminate\Http\Request;
use App\Favorite;
class FavoriteController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Reply $reply)
    {
//        $isReply = get_class($reply);
//
//
//        if($isReply){
                    $reply->favorite();

                    Favorite::create([
                        'user_id'=> auth()->id(),
                        'favorited_id'=> $reply->id,
                        'favorited_type'=>get_class($reply)
                        // 'reply_id'=> $reply->id,


                    ]);

//        }
//            $thread->favorite();
//
//                 Favorite::create([
//                        'user_id'=> auth()->id(),
//                        'favorited_id'=> $thread->id,
//                        'favorited_type'=>get_class($thread)
//                        // 'reply_id'=> $reply->id,
//
//
//                    ]);


             return back()->with('flash','Liked');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {

        $thread->favorite();

        Favorite::create([
            'user_id'=> auth()->id(),
            'favorited_id'=> $thread->id,
            'favorited_type'=>get_class($thread),
            // 'reply_id'=> $reply->id,


        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Thread $thread)
    {
//        $thread->unfavorite();
         $thread->favorites()->where($attributes)->get()->each(function($favorite){

            $favorite->delete();

         });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply, Thread $thread)
    {

        $isReply = get_class($reply);


        if($isReply){
        $reply->unfavorite();
    }

//        dd($thread->favorites->unfavorite());
//        $thread->unfavorite();

        $thread->unfavorite();
    }




}

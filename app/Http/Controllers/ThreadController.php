<?php

namespace App\Http\Controllers;

//use App\Favorite;
use App\Rules\Recaptcha;
use App\Thread;
use App\Filters\ThreadFilters;
use App\User;
use App\Channel;
//use App\Reply;
use App\Activity;
use Carbon\Carbon;
use App\Inspections\Spam;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Trending;
use Zttp\Zttp;

class ThreadController extends Controller
{
 public $trending;


    public function __construct(){

        return $this->middleware('auth')->only(['create','store']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Channel $channel, ThreadFilters $filters, Trending $trending)
    {

//        phpinfo();
////        die();
        $threads =  Thread::with('channel')->latest();

        if($channel->exists){

            $threads->where('channel_id', $channel->id, $user->id) ;
        }

    // dd($threads);
         if(request()->wantsJson()){

            return $threads;

        }



        // dd($threads->toSql());

        $threads = $threads->filter($filters)->paginate(5);
        // dd($threads->toArray());
        // $threads = Thread::filter($filters)->get();
        // $threads = $this->getThreads($channel);



// next two methods are one and we moved extracted to Redis responsible class Trending
        // $trending = array_map('json_decode', Redis::zrevrange('trending_threads', 0, 4));
    
        // $trending = collect(Redis::zrevrange('trending_threads', 0, 4))->map( function($thread){
        //     return json_decode($thread);
        // });

//dd($threads);
        return view('threads.index', [

                'threads'=>$threads,
                'trending'=>$trending->get()


            ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Channel $channel,Thread $thread)
    {

       return view('threads.create', compact('thread', 'channel'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Channel $channel, Request $request, Spam $spam)
    {


//dd(request()->all());

        $this->validate(request(),[
            'title'=>'required',
            'body'=>'required|min:5',
            'channel_id'=>'required|exists:channels,id',
            'g-recaptcha-response' =>['required', new Recaptcha()]
            ]);
//
//        $response= Zttp::asFormParams()->post('https://www.google.com/recaptcha/api/siteverify',[
//           'secret'=>config('services.recaptcha.secret'),
//           'response'=>$request->input('g-recaptcha-response'),
//           'remote_ip'=>$_SERVER['REMOTE_ADDR']
//
//        ]);
//
//
//
////        dd($response->json());
//
//        if(! $response->json()['success']){
//
//            return back()->with('flash','recaptcha error!');
//        }


        try{
       $spam->detect(request('body'));
       $spam->detect(request('title'));            
        }catch(\Exception $e){

            return back()->with('flash','No Cuss!');
        }


        // dd($request->all());
        $thread= Thread::create([
                'user_id'=>auth()->id(),
                'channel_id'=>request('channel_id'),
                'title'=>request('title'),
                'body'=>request('body'),
                'slug'=>request('title')

            ]);



    return redirect($thread->path())->with('flash','Your post has been published');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */


    public function show($channel, Thread $thread, Trending $trending)
    {
        // abstractred cache methods on User
        if( auth()->user()) {
        auth()->user()->read($thread);
        }

        // chache the user created_at timestamps

         // $key = sprintf('users.%s.visits.%s' , auth()->id(), $thread->id);
         // cache()->forever($key, Carbon::now());


        // return $thread;
        // return $thread->load('reply.favorites')->load('reply.user');
        // dd($thread->reply());



        $trending->addUp($thread);
        $thread->recordVisits();


        // Redis::zincrby('trending_threads', 1, json_encode([

        //         'title'=>$thread->title,
        //         'path'=> $thread->path()

        //     ]));

        $thread->load('user');
//        dd($thread->reply);
        return view('threads.show',[

                'thread'=>$thread,
//                 'replies'=>$thread->reply()->latest()->paginate(7),

            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */


     public function update($channel, Thread $thread,Spam $spam)
     {

         //authorization
        $this->authorize('update', $thread);
         //verfication
        $this->validate(request(),[

           'body'=>'required',
           'title'=>'required'

        ]);
             $spam->detect(request('body'));
             $spam->detect(request('title'));

         //update


         $thread->update(request(['body', 'title']));
     }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */


     public function lock($channel, Thread $thread)
     {

         $thread->lock();
     }

    public function unlock($channel, Thread $thread)
    {

        $thread->unlock();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */


    public function destroy($channel, Thread $thread,  Trending $trending)
    {
        // Reply::where('thread_id',$thread->id)->delete();
        // $thread->reply()->delete();




        // if ($thread->user_id != auth()->id()){
        //     if(request()->wantsJson()){

        //         return response(['status'=>'Premission Denied'], 407);  
        //     }

        //     return redirect('/login');

        // }


        $this->authorize('delete', $thread);

        $thread->delete();

        $thread->resetVisits();

        if (request()->expectsJson()){
            return response(['status'=>'Post deleted']);
        }

        return redirect('/threads')->with('flash', 'Deleted');
    }



//    test







    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function likeThread(Thread $thread)
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
    public function unlikeThread(Thread $thread)
    {

//        $attributes = ['user_id'=>auth()->id()];
//
//         Favorite::where($attributes)->get()->each(function($favorite){
//
//           $this->favorite->delete();
//
//         });
        $this->unfavorite();
//        dd( $favorited->thread);
    }












}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;
//use App\User;
use App\Inspections\Spam;
//use App\Rules\SpamFree;
use Illuminate\Notifications\Notifiable;
class ReplyController extends Controller
{
  use Notifiable;



    public function index($channelId, Thread $thread)
    {

         return $reply = $thread->reply()->paginate(7);


//         return compact('$reply', 'thread');

    }




    public function store($channelId, Thread $thread)
    {
        if(\Gate::denies('create', new Reply)){

            return response('Give yourself a minute', 422);

            }
     
    try{

    if ($thread->locked){

        return response('Topic is locked', 422);
    }


            // $this->validate(request(),[
            //     "body"=>'required | min:4'
            //     ]);


            // $spam->detect(request('body'));


    // limit the user of repeating an action for a minute
            // $this->authorize('create', new Reply);
            $this->validateReply();


            $reply= $thread->addReply([
                    'user_id'=>auth()->id(),
                    'body'=>request('body')

                ]);


            //  preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);
            //     $names=$matches[1];
            //     foreach ($names as $name) {
            //     $user = User::whereName($name)->first();

            //     if($user){
            //     $user->notify(new YouWereMentioned($reply));
            //     }
            // }



             
            if(request()->expectsJson()){
                return $reply->load('user');

            }






    }catch (\Exception $e){

        return response('Sorry we can not update your reply with your current inputs', 422);

        }
            
 


        return $reply->load('user');
        // return back()->with('flash', 'your reply has been posted');
    }



    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Reply $reply)
    {
            $this->authorize('update', $reply);          

        try{

            // $this->validate(request(),[
            // "body"=>'required | min:4'
            // ]);

            //  $spam->detect(request('body'));


            $this->validateReply();


            $reply->update(request(['body']));

         }catch(\Exception $e){

                return response('Sorry we can not update your reply with your current inputs', 422);
         }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {

        $this->authorize('update', $reply);
        $reply->delete();


        if (request()->expectsJson()){
            return response(['status'=>'Post deleted']);
        }


        return back()->with('flash', 'reply removed');
    }




        function validateReply()
        {

            $this->validate(request(),["body"=>'required | min:4']);

             resolve(Spam::class)->detect(request('body'));


        }










}

<?php

namespace App\Http\Controllers;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class BestReplyController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Reply $reply)
    {
        abort_if($reply->thread->user_id !== auth()->id(), 403);
        // we can use the threadPolicy instead

        // $this->authorize('update', $reply->thread);
        $reply->thread->update(['best_reply_id' => $reply->id]);





    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

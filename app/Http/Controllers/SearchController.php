<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Trending;
use Illuminate\Http\Request;

class SearchController extends Controller
{


    public function show(Trending $trending)
    {
//        $searchQuery = request('q');
//
//        $threads = Thread::search($searchQuery)->paginate(25);
//        if (request()->expectsJson()) {
//
//            return $threads;
//        }

        return view('threads.search', [

//            'threads' => $threads,
            'trending' => $trending->get()


        ]);

    }
}
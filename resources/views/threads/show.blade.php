@extends('layouts.app')

@section('content')
<thread-view :thread="{{ $thread  }}" inline-template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        @include('threads._showThread')


             <div class="header text-center"><h1>Replies...<h1></div>

              <replies 
             
                @removed="repliesCount--" 
                @added="repliesCount++"></replies>
              {{--   @foreach ($replies as $reply)
                  @include('threads.reply')
                @endforeach --}}

  





@include('../layouts.errors')

        </div>





        <div class="col-md-4">

          <div class="card">
              <div class="card-body">
                <p>This thread was publish <i class="text-info">{{$thread->created_at->diffForHumans()}}</i></p>
                <p>By <a href="{{ route('profile', $thread->user->name) }}" class="text-warning">{{$thread->user->name}}</a> and has <span v-text="repliesCount"></span> {{ str_plural('comment',$thread->reply_count ) }}</p>
              </div>
              <div class="d-flex ">
              <subscribe-button :state="{{ json_encode($thread->isSubscribedTo)}}" ></subscribe-button>
                <div class="ml-auto p-2">
              <button class="btn " :class="classes" @click="toggleLock" v-text="locked ? 'Unlock' : 'Lock' " v-show="isAdmin"></button>
                </div>
                </div>
          </div>
        </div>
    </div>
</div>

</thread-view>
@endsection

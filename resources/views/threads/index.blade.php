@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">Topics</h1>
            
            @forelse($threads as $thread)
            <div class="card" style="margin-bottom:2em;">
                <div class="card-header">
                    <a href="{{$thread->path()}}">
                        @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))


                        <strong>
                             {{$thread->title}}

                        </strong>

                        @else

                         {{$thread->title}}

                        @endif
                       




                    </a>
                    <i class="float-right">{{ $thread->created_at->diffForHumans()}}</i>


                </div>


                <div class="card-body">
                    

                     {{--{{$thread->body}}--}}
                    {!! strip_tags($thread->body ) !!}
                     <i class="float-right">by <a href="{{ route('profile', $thread->user->name) }}">
                     <img src="{{$thread->user->avatar_path}}" with="25" height="25" alt="{{$thread->user->name}}">
                      <i class="">{{ $thread->user->name }}</i>

                  </a>

                        

                     </i>

                     <br>
 

                     
                </div>
                <div class="card-footer">
                    {{ $thread->visits()?:0 }}  {{ str_plural('Visit',$thread->visits()) }}
                      <a href="{{$thread->path() }}">
                        <i class="float-right"> 
                    {{ $thread->reply_count}} {{ str_plural('Reply',$thread->reply_count ) }}
                        </i>
                     </a>  
                </div>
            </div>


            @empty

            <div class="container">
                <div class="card">
                    <div class="card-body justify-content-center row">
                        <p class="text-primary">
                            Oh...There's no content here YET
                        </p>
                        <p>Get yourself in it and <a href="{{route('create')}}" class="btn btn-link">

                            Post a topic</a> or <a href="{{route('forum')}}" class="btn btn-link">

                           Go to the Forum</a>
                    </div>
                </div>
            </div>

            @endforelse  
            <div class="row justify-content-md-center">
            {{$threads->render()}}
            </div>
        </div>


        <div class="col-md-4">


                <div class="card">
                    <div class="card-body">


                            <form action="/threads/search" method="get" >
                              <div class="form-group">

                                <input type="text"  name="q" placeholder="search" class="form-control">
                              </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">GO</button>
                                </div>
                            </form>
                    </div>

                </div>










            @if(count($trending))
                <div class="card">

                    <div class="card-header">
                    <h3>Tending Posts</h3>

                    </div>
                        <ul class="list-group">
                        @foreach($trending as $thread)
                            <li class="list-group-item"><a href="{{url($thread->path)}}">{{$thread->title}}</a></li>

                        @endforeach
                        </ul>
                </div>
          @endif      
       </div>     
    </div>
</div>

@endsection

@extends('layouts.app')
@section('head')


    <script src='https://www.google.com/recaptcha/api.js'></script>



@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">Post a New Thread</h1>
                <div class="card">
                    @if($thread)

                    {{$thread->title}}
                    
                    @endif
                </div>
            @if(auth()->check())

            <div class="">
                <form method="POST" action="{{url('/threads')}}">
                    @csrf
                    <div class="form-group">


                        <select name="channel_id" id="channel_id" class="form-control">

                            <option value="" >Choose a channel</option>

                            @foreach(App\Channel::all() as $channel)
                            <option value="{{$channel->id}}" {{ old('channel_id') == $channel->id ? 'selected':'' }}>{{$channel->name}}</option>
                            @endforeach
                        </select>

                    </div>
                   <div class="form-group">
                    <input name="title" id="title" placeholder="Title" class="form-control" value="{{old('title')}}">
                   </div>
                   <div class="form-group">
                       <wysiwyg name="body"></wysiwyg>

                    {{--<textarea rows="5" name="body" id="body" class="form-control" placeholder="wanna say somethin'!!" value="{{old('body')}}"></textarea>--}}
                   </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LcNJlMUAAAAAK3tIXHrOAR7czX1J_A9zdxoJNYC"></div>
                    </div>
                    <div class="form-group">
                     <button type="submit">Publish</button>
                 </div>
                </form>
            </div>
          @include('../layouts.errors')
            @else
            <p class="text-center">Please <a href="{{ route('login') }}">Sign in</a> to Create a topic</p>
              
            @endif


        </div>
    </div>
</div>
@endsection

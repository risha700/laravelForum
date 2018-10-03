@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="page-header">

      {{-- <h1 class="title">  {{$profileUser->name}}</h1> --}}
 <avatar-form :user="{{$profileUser}}" ></avatar-form>


{{--       @can('update', $profileUser)


        <form method="POST" action="/api/users/{{$profileUser->name}}/avatar" enctype="multipart/form-data">
          @csrf
          <input type="file" name="avatar">
          <button type='submit'>Upload Avatar</button>

        </form>

      @endcan
 --}}

     
{{--       <img src="{{asset($profileUser->avatar())}}" with="100" height="70"  alt="{{$profileUser->name}}">
 --}}







      <p class="text-info">Member since <small>{{$profileUser->created_at->diffForHumans()}} </small></p>

    </div>

              @forelse($activities as $date=>$activity)

              <div class="page-header">{{$date}}</div>
                @foreach($activity as $record)
                 {{--@if(view()->exists('profiles.activities.{$record->type}'))--}}
              @include("profiles.activities.{$record->type}", ['activity'=>$record])
                 {{--@endif--}}
                @endforeach
              
                @empty
                <h4 class="title">There's no activity yet</h4>
              @endforelse
           


            
              <div class="container">
                <div class="row justify-content-md-center">
                  <div class="col col-lg-4">

                  </div>
                </div>
              </div>

           
            </div>














  </div>

@endsection
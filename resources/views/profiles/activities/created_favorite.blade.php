
<div class="card" style="margin-bottom:2em;">
	<div class="card-header">
	{{ $profileUser->name }} Liked


	{{--@if($activity->subject->thread) {--}}
			   {{--return $activities->subject->thread->title;--}}
			{{--}--}}
	{{--@else--}}

			    {{--return $activities->subject->reply->title;--}}
	{{--@endif--}}


	<a href="{{ $activity->subject->favorited->path()  }}">
	 {{--<a href="{{ $activity->subject->favorited->thread->path()  }}">--}}
@if($activity->subject->thread)
			{{$activity->subject->thread->title }}</a>
		{{--{{ $activity->subject->favorited->thread->title }} </a>--}}
@endif
<div class="float-right">

{{$activity->subject->created_at->diffForHumans()}}
</div>
	</div>


	<div class="card-body">

		{{--@if ($activity->subject->reply->body )--}}


		{{--{!! $activity->subject->reply->body !!}--}}

			{{--@else--}}
			{!! $activity->subject->favorited->body !!}
			{{----}}
		{{--@endif--}}

	


	</div>
</div>


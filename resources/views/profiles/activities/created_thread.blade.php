@component('profiles.activities.index')

	@slot('heading')

		{{ $profileUser->name }} Posted a new thread
		<a href="{{ $activity->subject->path()  }}">{{ $activity->subject->title  }}</a>
	<div class="float-right">

		{{$activity->subject->created_at->diffForHumans()}}
	</div>
	@endslot

	





	@slot('body')


	{!! $activity->subject->body !!}
	@endslot

@endcomponent

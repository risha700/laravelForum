@component('profiles.activities.index')

	@slot('heading')

{{ $profileUser->name }} Replied to
<a href="{{ $activity->subject->thread->path()  }}">{{ $activity->subject->thread->title  }}</a>

	<div class="float-right">

	{{$activity->subject->thread->created_at->diffForHumans()}}
	</div>

	@endslot


	@slot('body')


	{!!  $activity->subject->body !!}
	@endslot

@endcomponent
 
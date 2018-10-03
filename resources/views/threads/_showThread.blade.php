    {{--Edit the thread--}}
    <div class="card" v-if="editing" v-cloak>
        <div class="card-header">

            <div class="form-group">
                 <input type="text" class="form-control" v-model="form.title">
            </div>
        </div>

        <div class="card-body">

            <div class="form-group">
                <wysiwyg name="body" v-model="form.body" :value="form.body"></wysiwyg>

                {{--<textarea  class="form-control" rows="5" v-model="form.body"></textarea>--}}

            </div>

        </div>

        <div class="card-footer d-flex">
            @can('update', $thread)

                    <button type="button" class="btn btn-link" @click="update">Update</button>


            @endcan
            <button class="btn" @click="cancel">Cancel</button>
            @can('delete', $thread)
                <form class="" action="{{ $thread->path() }}" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link">Delete</button>


                </form>
            @endcan
        </div>


    </div>



    {{--View the thread--}}

    <div class="card" v-else>
        <div class="card-header">
            <img src="{{$thread->user->avatar_path}}" with="50" height="50" alt="{{$thread->user->name}}">
            <a href="{{ route('profile', $thread->user->name) }}">{{$thread->user->name}}</a>
            Published:
            <span v-text="form.title"></span>
            {{--{{$thread->title}}--}}
            <i class="float-right">{{ $thread->created_at->diffForHumans() }}</i>
        </div>

        <div class="card-body" v-html="form.body">

            {{--{{$thread->body}}--}}

        </div>

        <div class="card-footer d-flex">
            @can('update', $thread)

                <button type="button" class="btn btn-link" @click="editing = true">Edit</button>

                <favorite :model="{{ $thread }}"></favorite>
            @endcan

            @can('delete', $thread)
                <form class="" action="{{ $thread->path() }}" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link">Delete</button>


                </form>
            @endcan
        </div>


    </div>
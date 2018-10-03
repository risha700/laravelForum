<div style="margin-top:2em;">
            <reply :attributes="{{$reply}}" inline-template v-cloak>

                <div>
                     
                 <div id="reply-{{ $reply->id }}" class="card">
                  <div class="card-header"><a href="{{ route('profile', $reply->user->name) }}"> {{$reply->user->name}}</a> said...


                    @if(auth()->check())

                    <favorite :reply="{{$reply}}"></favorite>

                    @endif
                    <div class="ml-auto p-2">
                      <div class="d-inline-flex p-2">
                        {{$reply->favorites->count()}}
                        <form method="POST" action="/replies/{{$reply->id}}/favorites">  
                          @csrf
                          <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled': '' }} >Favorite</button>


                        </form>
                      </div>
                    </div>
                    </div>

                  </div>
                      <div class="card-body">
                       
                        <div v-if="editing" >
                          <textarea class="form-control" v-model="body"></textarea>


                          <button class="btn" @click="update">
                            <i class="fa fa-check-circle" style="color:#28a745;font-size:2em;"></i></button>
                          <button class="btn btn-link-warning" @click="editing=false">
                            <i class="fa fa-times" style="color:#dc3545;font-size:2em;"></i></button>
                        </div>
                        <div v-else v-text="body">
                           {{$reply->body}}
                            <i class="float-right">{{$reply->created_at->diffForHumans()}}</i>

                        </div>
                          </div>

                           @can('update', $reply)
                           <div class="d-inline-flex p-2 flex-md-row-reverse">
                             <button class="btn d-flex" @click="editing=true">
                              <i class="fa fa-edit" style="color:#007bff;font-size:1.7em;"></i></button>

                             <button class="btn d-flex" @click="destroy">
                              <i class="fa fa-trash" style="color:#dc3545;font-size:1.7em;"></i></button>


                             {{-- <form class="" action="/replies/{{ $reply->id }}" method="POST">
                              @csrf
                              {{ method_field('DELETE') }}
                             <button type="submit" class="btn d-flex btn-link ">remove</button>


                             </form> --}}

                                </div>
                             @endcan
                      </div>
                    </div>
               

            </reply>
</div>
            <article class='post' data-postid="{{ $post->id }}">
                <div class='row'>
                    <div class='col-xs-6 username' id='username'>
                        @if ($post->user->image_url != null)
                        <img src='{{ route('user.image', ['filename' => $post->user->image_url]) }}' 
                             alt='{{ $post->user->username }}' height='20' />
                        @else
                        <img src='{{ asset('img/welcome/wolfe.jpg') }}' alt='The Wolfe' height='20' />
                        @endif
                        <a href="{{ route('user', $post->user->id) }}"><strong>{{ $post->user->username }}</strong></a>
                    </div>
                    <div class='col-xs-6 username text-right info'>
                        {{ $post->created_at->diffForHumans() }}
                    </div>
                </div>
                @if (Storage::disk('local')->has('posts/' . $post->image_url))
                <div class='col-md-12' id='post-img'>
                    <img class='img img-responsive' src='{{ route('post.image', ['filename' => $post->image_url]) }}' alt='Image of Post' />
                </div>
                @endif
                <!--
                <div class='info'>
                    Posted on {{ date('m/d/Y g:i a', strtotime($post->created_at)) }}
                </div>
                -->
                <div class='interaction'>
                    <div class='col-xs-1 like arrow-up {{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->type == 'like' ? 'clicked' : '' : ''  }}'
                         id='arrow-up-{{ $post->id }}'>
                        <span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>
                    </div>
                    <div class='col-xs-1 like' id='likes-{{ $post->id }}'>
                        {{ Auth::user()->likes()->where('post_id', $post->id)->where('type', 'like')->count() - 
                        Auth::user()->likes()->where('post_id', $post->id)->where('type', 'dislike')->count() }}
                    </div>
                    <div class='col-xs-1 like arrow-down {{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->type == 'dislike' ? 'clicked' : '' : ''  }}' 
                         id='arrow-down-{{ $post->id }}'>
                        <span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span>
                    </div>
                    <br />
                    <a class='report' href="#">Report</a>
                    @if(Auth::user() == $post->user)
                    | 
                    <a class='edit' href='#'>Edit</a> | 
                    <a id='delete{{ $post->id }}' onclick="displayWarningBox('#button{{$post->id}}');">Delete</a>
                    <div id='button{{ $post->id }}' class="alert alert-warning alert-dismissible fade in" role="alert" 
                         style="display: none;">
                        <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button> -->
                        <h4>Are you sure you want to delete this post?</h4> 
                        <!-- <p>
                            Change this and that and try again. Duis mollis, est non commodo luctus, nisi erat porttitor 
                            ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.
                        </p> -->
                        <p>
                            <button type="button" class="btn btn-warning" 
                                    onclick="document.location='{{ route('post.delete', ['post_id' => $post->id]) }}';">
                                Yes
                            </button> 
                            <button type="button" class="btn btn-default" aria-label="Close" onclick="$('#button{{$post->id}}').hide();">
                                No
                            </button>
                        </p> 
                    </div>
                    @endif
                </div>
                <div style='clear:both'></div>
                <p id='body'>{{ $post->body }}</p>
            </article>


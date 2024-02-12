<x-app-layout>
    <div class="my-5">
        <div class="container d-flex flex-column align-items-center w-50">
            <div class="top d-flex w-100">
                <div class="img w-25 d-flex justify-content-center align-items-center">
                    @if(strlen($data->profile_photo_path) > 0)
                        <img src="{{ asset('storage/'.$data->profile_photo_path) }}" alt="{{ $data->name }}" class="rounded-full h-20 w-20 object-cover"/>
                    @else
                        <img src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ $data->name }}" class="rounded-full h-20 w-20 object-cover">
                    @endif
                </div>

                <div class="info w-75 d-flex flex-column">
                    <div class="top d-flex justify-content-around">
                        <div class="posts d-flex flex-column align-items-center">
                            <button>
                                Posts
                                <p>{{ $data->posts()->where('user_id', $data->id)->count() }}</p>
                            </button>
                        </div>
                        <div class="followers d-flex flex-column align-items-center">
                            <button data-bs-toggle="modal" data-bs-target="#followers">
                                Followers
                                <p>{{ $data->followers()->where('status', 'accepted')->count() }}</p>
                            </button>
                        </div>
                        <div class="following d-flex flex-column align-items-center">
                            <button data-bs-toggle="modal" data-bs-target="#following">
                                Following
                                <p>{{ $data->following()->count() }}</p>
                            </button>
                        </div>
                    </div>
                    <div class="bottom">
                        <form class="d-flex justify-content-center" action="{{ route('profile.show') }}">
                            <button class="btn btn-sm btn-primary w-75">Edit Profile</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bottom w-100 mt-3 ">
                <div class="buttons mb-4 border-top border-dark-subtle w-100 d-flex justify-content-center pt-3">
                    <a href="{{ route('my_profile.index') }}" class="btn btn-outline-success"><i class="bi bi-images"></i> Posts</a>
                    <a href="{{ route('saved') }}" type="submit" class="btn btn-outline-primary ms-2"><i class="bi bi-save"></i> Saved</a>
                </div>

                <!-- USER POSTS -->
                <div class="posts">
                    @if(count(Auth::user()->posts()->orderBy('id', 'DESC')->get()) > 0)
                        <div class="row">
                            @foreach(Auth::user()->posts()->orderBy('id', 'DESC')->get() as $post)
                                @if(count($post->images()->get()) > 1)
                                    <div class="col-4 mb-4" style="position:relative;">
                                        <a data-bs-toggle="modal" data-bs-target="#post{{ $post->id }}m" style="cursor: pointer;">
                                            <div style="background-image: url('{{ asset('storage/'.$post->images()->first()->image_path) }}'); height: 250px;width: 250px;background-repeat: no-repeat;background-position: center;background-size: cover;border-radius: 6px;"></div>
                                            <div style="position:absolute; top: 3%; right: 11%;">
                                                <i class="fa-solid fa-images fa-flip-horizontal" style="color: #ffffff;"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- MODAL SLIDER IMGAE -->
                                    <div class="modal fade" id="post{{ $post->id }}m" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close ms-0 py-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="post d-flex justify-content-center py-5">
                                                    <div id="post{{ $post->id }}c" class="carousel slide my-3">
                                                        <div class="carousel-inner">
                                                            @foreach($post->images()->get() as $key => $image)
                                                                @if($key == 0)
                                                                    <div class="carousel-item carousel-image active" style="background-image: url('{{ asset('storage/'.$image->image_path) }}');"></div>
                                                                @else
                                                                    <div class="carousel-item carousel-image" style="background-image: url('{{ asset('storage/'.$image->image_path) }}');"></div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#post{{ $post->id }}c" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#post{{ $post->id }}c" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    </div>
                                                    <div class="comments d-flex flex-column justify-content-center w-25">
                                                        <div class="top d-flex align-items-center p-2" style="height: 60px;">
                                                            <div class="profile">
                                                                @if(strlen($post->user()->first()->profile_photo_path) > 0)
                                                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.$post->user()->first()->profile_photo_path) }}" alt="{{ $post->user()->first()['name'] }}">
                                                                @else
                                                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ $post->user()->first()['name'] }}">
                                                                @endif
                                                            </div>
                                                            <div class="info d-block w-75 border-bottom border-dark-subtle">
                                                                <b class="ms-2 mb-0">{{ $post->user()->first()->name }}</b>
                                                                <p class="ms-2 mb-0" style="word-wrap: break-word;">{{ $post->description }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="users p-2" style="overflow-y: scroll; height: 465px;">
                                                            @if(count($post->comments()->get()) > 0)
                                                                @foreach($post->comments()->get() as $comment)
                                                                <div class="comment d-flex p-2 mb-3">
                                                                    <div class="profile">
                                                                        @if(strlen(App\Models\User::find($comment->user_id)->profile_photo_path) > 0)
                                                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.App\Models\User::find($comment->user_id)->profile_photo_path) }}" alt="{{ App\Models\User::find($comment->user_id)->name }}">
                                                                        @else
                                                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ App\Models\User::find($comment->user_id)->name }}">
                                                                        @endif
                                                                    </div>
                                                                    <div class="info d-block w-75">
                                                                        <b class="ms-2 mb-0">{{ App\Models\User::find($comment->user_id)->name }}</b>
                                                                        <p class="ms-2 mb-0" style="word-wrap: break-word;">{{ $comment->comment }}</p>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            @else
                                                            <p class="ms-2 mb-0"></p>
                                                            @endif
                                                        </div>
                                                        <div class="buttons d-flex align-items-center justify-content-center" style="height: 60px;">
                                                            <form action="{{ route('comment', ['id' => $post->id]) }}" method="POST" class="d-flex justify-content-around">
                                                                @csrf
                                                                <input id="comment" name="comment" type="text" class="form-control w-75 border border-dark-subtle" placeholder="Add a comment...">
                                                                <button type="submit" class="btn btn-primary">Post</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                @else
                                    <div class="col-4 mb-4">
                                        <a data-bs-toggle="modal" data-bs-target="#post{{ $post->id }}m" style="cursor: pointer;">
                                            <div style="background-image: url('{{ asset('storage/'.$post->images()->first()->image_path) }}'); height: 250px;width: 250px;background-repeat: no-repeat;background-position: center;background-size: cover;border-radius: 6px;"></div>
                                        </a>
                                    </div>

                                    <!-- MODAL SINGLE IMAGE -->
                                    <div class="modal fade" id="post{{ $post->id }}m" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close ms-0 py-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="post d-flex justify-content-center py-5">
                                                <div class="carousel-image" style="background-image: url('{{ asset('storage/'.$post->images()->first()->image_path) }}');"></div>
                                                <div class="comments d-flex flex-column justify-content-center w-25">
                                                    <div class="top d-flex align-items-center p-2" style="height: 60px;">
                                                        <div class="profile">
                                                            @if(strlen($post->user()->first()->profile_photo_path) > 0)
                                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.$post->user()->first()->profile_photo_path) }}" alt="{{ $post->user()->first()['name'] }}">
                                                            @else
                                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ $post->user()->first()['name'] }}">
                                                            @endif
                                                        </div>
                                                        <div class="info d-block w-75 border-bottom border-dark-subtle">
                                                            <b class="ms-2 mb-0">{{ $post->user()->first()->name }}</b>
                                                            <p class="ms-2 mb-0" style="word-wrap: break-word;">{{ $post->description }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="users p-2" style="overflow-y: scroll; height: 465px;">
                                                        @if(count($post->comments()->get()) > 0)
                                                            @foreach($post->comments()->get() as $comment)
                                                            <div class="comment d-flex p-2 mb-3">
                                                                <div class="profile">
                                                                    @if(strlen(App\Models\User::find($comment->user_id)->profile_photo_path) > 0)
                                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.App\Models\User::find($comment->user_id)->profile_photo_path) }}" alt="{{ App\Models\User::find($comment->user_id)->name }}">
                                                                    @else
                                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ App\Models\User::find($comment->user_id)->name }}">
                                                                    @endif
                                                                </div>
                                                                <div class="info d-block w-75">
                                                                    <b class="ms-2 mb-0">{{ App\Models\User::find($comment->user_id)->name }}</b>
                                                                    <p class="ms-2 mb-0" style="word-wrap: break-word;">{{ $comment->comment }}</p>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @else
                                                        <p class="ms-2 mb-0"></p>
                                                        @endif
                                                    </div>
                                                    <div class="buttons d-flex align-items-center justify-content-center" style="height: 60px;">
                                                        <form action="{{ route('comment', ['id' => $post->id]) }}" method="POST" class="d-flex justify-content-around">
                                                            @csrf
                                                            <input id="comment" name="comment" type="text" class="form-control w-75 border border-dark-subtle" placeholder="Add a comment...">
                                                            <button type="submit" class="btn btn-primary">Post</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            No Posts yet
                        </div>
                    @endif
                </div>
            </div>


            <!-- FOLLOWERS MODAL -->
            <div class="modal fade" id="followers" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="followersLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Followers</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                @if(count($followers) > 0)
                                    @foreach($followers as $follower)
                                        @foreach($follower as $follower_data)
                                            <div class="border border-black rounded d-flex justify-content-between mb-3 p-2">
                                                <div class="info d-flex align-items-center">
                                                    @if(strlen($follower_data->profile_photo_path) > 0)
                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.$follower_data->profile_photo_path) }}" alt="{{ $follower_data['name'] }}">
                                                    @else
                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ $data['name'] }}">
                                                    @endif
                                                    <span class="ms-2">{{ $follower_data->name }}</span>
                                                </div>
                                                <div class="buttons d-flex">
                                                    <form action="{{ route('my_profile.destroy', ['my_profile' => $follower_data->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" type="submit">Remove Follower</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                @else
                                <div class="alert alert-danger" role="alert">
                                    No Followers
                                </div>
                            @endif
                        </div>
                        </div>
                    </div>
            </div>
            
            <!-- FOLLOWING MODAL -->
            <div class="modal fade" id="following" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="followingLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Following</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                @if(count($following) > 0)
                                    @foreach($following as $follow)
                                        @foreach($follow as $follower_data)
                                            <div class="border border-black rounded d-flex justify-content-between mb-3 p-2">
                                                <div class="info d-flex align-items-center">
                                                    @if(strlen($follower_data->profile_photo_path) > 0)
                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.$follower_data->profile_photo_path) }}" alt="{{ $follower_data['name'] }}">
                                                    @else
                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ $follower_data['name'] }}">
                                                    @endif
                                                    <span class="ms-2">{{ $follower_data->name }}</span>
                                                </div>
                                                <div class="buttons d-flex">
                                                    <form action="{{ route('follow.show', ['follow' => $follower_data->id]) }}" method="GET">
                                                        @csrf
                                                        <button class="btn btn-sm btn-primary" type="submit">Unfollow</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                @else
                                <div class="alert alert-danger" role="alert">
                                    No Following Users
                                </div>
                            @endif
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
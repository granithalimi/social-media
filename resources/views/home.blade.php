<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="container mt-5 d-flex flex-column align-items-center">
        <div class="buttons d-flex w-50">
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary me-2">Home</a>
            <a href="{{ route('foryoupage') }}" class="btn btn-sm btn-outline-primary">For You Page</a>
        </div>

        @if(count($posts) > 0)
            <div class="posts mt-3">
                @foreach($posts as $friend_post)
                    @foreach($friend_post as $post)
                        <!-- SLIDER POSTS -->
                        @if(count($post->images()->get()) > 1)
                            <div class="post">
                                <div class="top d-flex align-items-center p-2">
                                    @if(strlen($post->user()->first()->profile_photo_path) > 0)
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.$post->user()->first()->profile_photo_path) }}" alt="{{ $post->user()->first()['name'] }}">
                                    @else
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ $post->user()->first()['name'] }}">
                                    @endif
                                    <div class="name">
                                        <span class="ms-2">{{ $post->user()->first()->name }}</span>
                                    </div>
                                </div>
                                <div id="post{{ $post['id'] }}" class="carousel slide my-1">
                                    <div class="carousel-inner">
                                        @foreach($post->images()->get() as $key => $image)
                                            @if($key == 0)
                                                <div class="carousel-item carousel-image active" style="background-image: url('{{ asset('storage/'.$image->image_path) }}');"></div>
                                            @else
                                                <div class="carousel-item carousel-image" style="background-image: url('{{ asset('storage/'.$image->image_path) }}');"></div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#post{{ $post['id'] }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#post{{ $post['id'] }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <div class="bottom mb-3">
                                    <div class="buttons d-flex justify-content-between mt-2 mb-3">
                                        <div class="left d-flex">
                                            <form action="{{ route('like', ['id' => $post->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger me-2">
                                                    @if(count(App\Models\Like::where('user_id', Auth::user()->id)->where('post_id', $post->id)->get()) > 0)
                                                    <i class="bi bi-suit-heart-fill"></i>
                                                    @else
                                                        <i class="bi bi-heart"></i>
                                                    @endif
                                                </button>
                                            </form>
                                            <a class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#post{{ $post->id }}m">
                                                <i class="bi bi-chat"></i>
                                            </a>
                                        </div>
                                        <div class="right">
                                            <form action="{{ route('save', ['id' => $post->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning me-2">
                                                    @if(count(App\Models\Save::where('user_id', Auth::user()->id)->where('post_id', $post->id)->get()) > 0)
                                                        <i class="bi bi-save-fill"></i>
                                                    @else
                                                        <i class="bi bi-save"></i>
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="my-0 mb-0">
                                        @if($post->likes()->count() == 1)
                                            {{ $post->likes()->count() }} like
                                        @elseif($post->likes()->count() == 0)
                                            no likes
                                        @else
                                            {{ $post->likes()->count() }} likes
                                        @endif
                                    </p>
                                    <p><b>{{ $post->user()->first()->name }}</b> {{$post->description}}</p>
                                    <hr>
                                </div>
                            </div>
                            
                            <!-- MODAL SLIDER POSTS -->
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
                            <!-- SINGLE IMAGE POSTS -->
                            <div class="post">
                                <div class="top d-flex align-items-center p-2">
                                    @if(strlen($post->user()->first()->profile_photo_path) > 0)
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.$post->user()->first()->profile_photo_path) }}" alt="{{ $post->user()->first()['name'] }}">
                                    @else
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ $post->user()->first()['name'] }}">
                                    @endif
                                    <div class="name">
                                        <span class="ms-2">{{ $post->user()->first()->name }}</span>
                                    </div>
                                </div>
                                <div class="carousel-image" style="background-image: url('{{ asset('storage/'.$post->images()->first()->image_path) }}');"></div>
                                <div class="bottom mb-3">
                                <div class="buttons d-flex justify-content-between mt-2 mb-3">
                                    <div class="left d-flex">
                                        <form action="{{ route('like', ['id' => $post->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger me-2">
                                                @if(count(App\Models\Like::where('user_id', Auth::user()->id)->where('post_id', $post->id)->get()) > 0)
                                                <i class="bi bi-suit-heart-fill"></i>
                                                @else
                                                    <i class="bi bi-heart"></i>
                                                @endif
                                            </button>
                                        </form>
                                        <a class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#post{{ $post->id }}m">
                                            <i class="bi bi-chat"></i>
                                        </a>
                                    </div>
                                    <div class="right">
                                        <form action="{{ route('save', ['id' => $post->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning me-2">
                                                @if(count(App\Models\Save::where('user_id', Auth::user()->id)->where('post_id', $post->id)->get()) > 0)
                                                    <i class="bi bi-save-fill"></i>
                                                @else
                                                    <i class="bi bi-save"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p class="my-0 mb-0">
                                    @if($post->likes()->count() == 1)
                                        {{ $post->likes()->count() }} like
                                    @elseif($post->likes()->count() == 0)
                                        no likes
                                    @else
                                        {{ $post->likes()->count() }} likes
                                    @endif
                                </p>
                                <p><b>{{ $post->user()->first()->name }}</b> {{$post->description}}</p>
                                <hr>
                            </div>
                            </div>

                            <!-- MODAL SINGLE IMAGE POSTS -->
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
                @endforeach
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                No Posts yet!
            </div>
        @endif
    </div>
</x-app-layout>

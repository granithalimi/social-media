<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 d-flex flex-column align-items-center">
            @if($users->count())
                @foreach($users as $user)
                    <div class="border border-black rounded d-flex justify-content-between mb-3 p-2 w-50">
                        <div class="info d-flex align-items-center">
                            @if(strlen($user->profile_photo_path) > 0)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="{{ $user['name'] }}">
                            @else
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ $user['name'] }}">
                            @endif
                            <span class="ms-2">{{ $user['name'] }}</span>
                        </div>
                        <div class="buttons">
                            <form action="{{ route('follow.show', ['follow' => $user->id]) }}" method="GET">
                                @csrf
                                @if(count(App\Models\Follow::where('sender_id', Auth::user()->id)->where('receiver_id', $user->id)->where('status', 'pending')->get()) > 0)
                                    <button class="btn btn-sm btn-secondary" type="submit">Requested</button>
                                @elseif(count(App\Models\Follow::where('sender_id', Auth::user()->id)->where('receiver_id', $user->id)->where('status', 'accepted')->get()) > 0)
                                    <button class="btn btn-sm btn-primary" type="submit">Unfollow</button>
                                @else
                                    <button class="btn btn-sm btn-primary" type="submit">Follow</button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p>no</p>
            @endif
        </div>
    </div>
</x-app-layout>

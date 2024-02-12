<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-flex flex-column align-items-center">
                @if(count($notifs) > 0)
                    @foreach($notifs as $followers)
                        @foreach($followers as $data)
                            <div class="border border-black rounded d-flex justify-content-between mb-3 p-2 w-50">
                                <div class="info d-flex align-items-center">
                                    @if(strlen($data->profile_photo_path) > 0)
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.$data->profile_photo_path) }}" alt="{{ $data['name'] }}">
                                    @else
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ $data['name'] }}">
                                    @endif
                                    <span class="ms-2"><b>{{ $data['name'] }}</b> has sent you a follow request</span>
                                </div>
                                <div class="buttons d-flex">
                                    <form action="{{ route('follow.update', ['follow' => $data->id]) }}" method="POST" class="me-2">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-success" type="submit">Accept</button>
                                    </form>
                                    <form action="{{ route('follow.destroy', ['follow' => $data->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Decline</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @else
                <div class="alert alert-danger w-50" role="alert">
                    No Follow Requests yet
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

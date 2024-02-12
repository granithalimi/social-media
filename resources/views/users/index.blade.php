<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    
    <div class="py-5">
        <div class="container">
            @if(count($users) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <td>#id</td>
                            <td>Profile</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Roles</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user['id'] }}</td>
                                <td>
                                    @if(strlen($user->profile_photo_path) > 0)
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="{{ $user['name'] }}">
                                    @else
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/default-photo/default.jpg') }}" alt="{{ $user['name'] }}">
                                    @endif
                                </td>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>Admin</td>
                                <td class="d-flex justify-content-center">
                                    <form action="{{ route('users.destroy', ['user' => $user['id']]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-danger" role="alert">
                    No Users!!
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

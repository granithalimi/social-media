<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="my-5">
        <div class="container d-flex flex-column align-items-center">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger w-25" role="alert">
                    {{ $error }}
                </div>
            @endforeach
            <form action="{{ route('post.store') }}" method="POST" class="d-flex flex-column align-items-center" enctype="multipart/form-data">
                @csrf
                <input type="file" name="pictures[]" multiple class="mb-3" enctype="multipart/form-data">
                <input type="text" name="description" id="description" class="form-control mb-3 border-dark-subtle" placeholder="description" />
                <button type="submit" class="btn btn-lg btn-outline-primary">Post</button>
            </form>
        </div>
    </div>
</x-app-layout>

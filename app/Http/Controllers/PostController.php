<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('post.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, ['pictures.*' => 'required|image']);
        Post::create(['user_id' => Auth::user()->id, 'description' => $request->description]);

        if($request->hasfile('pictures')){
            $pictures = $request->file('pictures');
            foreach($pictures as $picture){
                $image = $picture->getClientOriginalName();
                $name = pathinfo($image, PATHINFO_FILENAME);
                $ext = pathinfo($image, PATHINFO_EXTENSION);
                $filename = $name.".".$ext;
                $last_post_id = Post::orderBy('id', 'DESC')->first()->id;
                
                Storage::putFileAs('public/posts-images/', $picture, $filename);
                Image::create(['post_id' => $last_post_id, 'image_path' => 'posts-images/'.$filename]);
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

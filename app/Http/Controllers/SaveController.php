<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Save;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SaveController extends Controller
{
    public function index(){
        // Get Followers Info
        $followers = Auth::user()->followers()->where('status', 'accepted')->get();
        $followers_data = [];

        foreach($followers as $follower){
            $followers_data[] = $follower->userSender()->get();
        }
        
        // Get Following Info
        $followers = Auth::user()->following()->get();
        $following_data = [];

        foreach($followers as $follower){
            $following_data[] = $follower->userReceiver()->get();
        }

        // Get saved Posts
        $saves = Auth::user()->saves()->orderBy('id', 'DESC')->get();
        $post_ids = [];
        foreach($saves as $save){
            $post_ids[] = $save->post_id;
        }

        $posts = [];
        foreach($post_ids as $post){
            $posts[] = Post::where('id', $post)->get();
        }

        return view('my_profile.saved', [
            'data' => Auth::user(),
            'followers' => $followers_data,
            'following' => $following_data,
            'posts' => $posts
        ]);
    }

    public function store(Request $request, $id){
        $user_id = Auth::user()->id;
        $saved_post = Save::where('user_id', $user_id)->where('post_id', $id)->get();

        if(count($saved_post) > 0){
            Save::where('user_id', $user_id)->where('post_id', $id)->delete();
        }else{
            Save::create(['user_id' => $user_id, 'post_id' => $id]);
        }

        return redirect()->back();
    }
}

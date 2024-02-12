<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(){
        $following_users = Auth::user()->following()->where('status', 'accepted')->get();
        $posts = [];
        foreach($following_users as $following_user){
            $posts[] = Post::where('user_id', $following_user->receiver_id)->get();
        }

        $last_posts = array_reverse($posts);
        
        return view('home', [
            'posts' => $last_posts
        ]);
    }

    public function forYouPage(){
        $all = Post::orderBy('id', 'DESC')->get();
        $fyp = [];
        foreach($all as $one){
            $fyp[] = $one;
        }

        return view('fyp', ['posts' => $fyp]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request, $id){
        $user_id = Auth::user()->id;
        $liked_post = Like::where('user_id', $user_id)->where('post_id', $id)->get();

        if(count($liked_post) > 0){
            Like::where('user_id', $user_id)->where('post_id', $id)->delete();
        }else{
            Like::create(['user_id' => $user_id, 'post_id' => $id]);
        }

        return redirect()->back()->with('success', 'Like created successfully');
    }
}

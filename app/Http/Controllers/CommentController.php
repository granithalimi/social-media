<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id){
        $user_id = Auth::user()->id;
        $comment = $request->comment;

        Comment::create(['user_id' => $user_id, 'post_id' => $id, 'comment' => $comment]);

        return redirect()->back()->with('success', 'Comment created successfully');
    }
}

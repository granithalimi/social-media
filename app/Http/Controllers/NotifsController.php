<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifsController extends Controller
{
    public function index(){
        $followers = User::find(Auth::user()->id)->followers()->where('status', 'pending')->get();
        $followers_data = [];

        foreach($followers as $follower){
            $followers_data[] = $follower->userSender()->get();
        }

        return view('notifs', ['notifs' => $followers_data]);
    }
}


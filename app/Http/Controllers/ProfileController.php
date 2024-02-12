<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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

        return view('my_profile.index', [
            'data' => Auth::user(),
            'followers' => $followers_data,
            'following' => $following_data
        ]);
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
        //
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
        Follow::where('status', 'accepted')->where('sender_id', $id)->delete();
        return redirect()->back();
    }
}

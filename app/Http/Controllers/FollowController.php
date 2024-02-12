<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $follow_request = Follow::where('sender_id', Auth::user()->id)->where('receiver_id', $id)->get();

        if(count($follow_request) > 0){
            Follow::where('sender_id', Auth::user()->id)->where('receiver_id', $id)->delete();
        } else{
            Follow::create(['sender_id' => Auth::user()->id, 'receiver_id' => $id]);
        }
        return redirect()->back();
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
        Follow::where('sender_id', $id)->where('status', 'pending')->update(['status' => 'accepted']);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Follow::where('sender_id', $id)->where('status', 'pending')->update(['status' => 'declined']);
        return redirect()->back();
    }
}

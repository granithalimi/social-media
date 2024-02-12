<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request){
        $search = $request->users;
        return view('search.index', [
            'users' => User::where('name', 'like', '%'.$search.'%')->get()->whereNotIn('id', Auth::user())
        ]);
    }
}

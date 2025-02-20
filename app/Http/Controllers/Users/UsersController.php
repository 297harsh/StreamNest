<?php

namespace App\Http\Controllers\Users;

use App\Models\Following\Following;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //followedShows
    public function followedShows(Request $request)
    {
        $followedShows = Following::select()->orderBy('id', 'desc')->where('user_id', Auth::user()->id)->get();

        return view('users.followed-shows', compact('followedShows'));
    }
}

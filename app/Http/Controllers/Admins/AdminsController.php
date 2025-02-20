<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

use App\Models\Admin\Admin;
use App\Models\Show\Show;
use App\Models\Category\Category;
use App\Models\Episode\Episode;

class AdminsController extends Controller
{
    //ViewLogin
    public function viewLogin()
    {
        return view('admins.login');
    }

    //CheckLogin
    public function checkLogin(Request $request)
    {
        //     $request->validate([
        //         'email' => 'required',
        //         'password' => 'required',
        //     ]);
        //     $credentials = $request->only('email', 'password');
        //     if (Auth::guard('admin')->attempt($credentials)) {
        //         return view('admins.dashboard');
        //     }
        //     return Redirect::route('login.view')->with('error', 'Invalid credentials');
        // }


        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            return redirect()->route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }

    //Dashboard
    public function Dashboard()
    {
        $adminsCount = Admin::select()->count();
        $showsCount = Show::select()->count();
        $genresCount = Category::select()->count();
        $episodesCount = Episode::select()->count();
        return view('admins.dashboard', compact('adminsCount', 'showsCount', 'genresCount', 'episodesCount'));
    }


    //allAdmins
    public function allAdmins()
    {
        $allAdmins = Admin::select()->orderBy('id', 'asc')->get();

        return view('admins.alladmins', compact('allAdmins'));
    }

    //createAdmins
    public function createAdmins()
    {
        return view('admins.createadmins');
    }

    //storeAdmins
    public function storeAdmins(Request $request)
    {

        $storeAdmins = Admin::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        if ($storeAdmins) {
            return Redirect::route('all.admins')->with(['success' => 'Admin created successfully']);
        }
    }


    //displayAllShows
    public function displayAllShows()
    {
        $shows = Show::select()->orderBy('id', 'desc')->get();
        return view('admins.allshows', compact('shows'));
    }

    //createShows
    public function createShows()
    {
        $categories = Category::all();
        $shows = Show::all();
        return view('admins.createshows', compact('shows', 'categories'));
    }

    //storeShows
    public function storeShows(Request $request)
    {

        Request()->validate([
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
            'type' => 'required',
            'studios' => 'required',
            'date_aired' => 'required',
            'status' => 'required',
            'genres' => 'required',
            'duration' => 'required',
            'quality' => 'required',

        ]);

        $destinationPath = 'img/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);


        $storeShows = Show::create([
            "name" => $request->name,
            "image" => $myimage,
            "description" => $request->description,
            "type" => $request->type,
            "studios" => $request->studios,
            "date_aired" => $request->date_aired,
            "status" => $request->status,
            "genres" => $request->genres,
            "duration" => $request->duration,
            "quality" => $request->quality,


        ]);
        if ($storeShows) {
            return Redirect::route('all.shows')->with(['success' => 'Show created successfully']);
        }
    }


    //deleteShows
    public function deleteShows($id)
    {
        $deleteShows = Show::find($id);

        if (File::exists(public_path('img/' . $deleteShows->image))) {
            File::delete(public_path('img/' . $deleteShows->image));
        } else {
            //dd('File does not exists.');
        }

        $deleteShows->delete();
        if ($deleteShows) {
            return Redirect::route('all.shows')->with(['delete' => 'Show deleted successfully']);
        }
    }


    //displayAllGenres
    public function displayAllGenres()
    {
        $genres = Category::select()->orderBy('id', 'desc')->get();
        return view('admins.allgenres', compact('genres'));
    }

    //createGenres
    public function createGenres()
    {
        return view('admins.creategenres');
    }

    //storeGenres
    public function storeGenres(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $storeGenres = Category::create([
            "name" => $request->name,
        ]);
        if ($storeGenres) {
            return Redirect::route('all.genres')->with(['success' => 'Genre created successfully']);
        }
    }

    //deleteGenres
    public function deleteGenres($id)
    {
        $deleteGenres = Category::find($id);
        $deleteGenres->delete();
        if ($deleteGenres) {
            return Redirect::route('all.genres')->with(['delete' => 'Genre deleted successfully']);
        }
    }


    //displayAllEpisodes
    public function displayAllEpisodes()
    {
        $episodes = Episode::select()->orderBy('id', 'desc')->get();
        return view('admins.allepisodes', compact('episodes'));
    }

    //createEpisodes
    public function createEpisodes()
    {
        $shows = Show::all();
        return view('admins.createepisodes', compact('shows'));
    }

    //storeEpisodes
    public function storeEpisodes(Request $request)
    {
        $request->validate([
            'show_id' => 'required',
            'episode_name' => 'required',
            'video' => 'required',
            'thumbnail' => 'required',
        ]);

        $destinationPath = 'thumbnail/';
        $myimage = $request->thumbnail->getClientOriginalName();
        $request->thumbnail->move(public_path($destinationPath), $myimage);

        $destinationPath = 'videos/';
        $myvideo = $request->video->getClientOriginalName();
        $request->video->move(public_path($destinationPath), $myvideo);


        $storeEpisodes = Episode::create([
            "show_id" => $request->show_id,
            "episode_name" => $request->episode_name,
            "video" => $myvideo,
            "thumbnail" => $myimage,
        ]);
        if ($storeEpisodes) {
            return Redirect::route('all.episodes')->with(['success' => 'Episode created successfully']);
        }
    }

    //deleteEpisodes
    public function deleteEpisodes($id)
    {
        $deleteEpisodes = Episode::find($id);

        if (File::exists(public_path('thumbnail/' . $deleteEpisodes->thumbnail)) && File::exists(public_path('videos/' . $deleteEpisodes->video))) {
            File::delete(public_path('thumbnail/' . $deleteEpisodes->thumbnail));
            File::delete(public_path('videos/' . $deleteEpisodes->video));
        };

        $deleteEpisodes->delete();
        if ($deleteEpisodes) {
            return Redirect::route('all.episodes')->with(['delete' => 'Episode deleted successfully']);
        }
    }
}

<?php

namespace App\Http\Controllers\Anime;

use App\Http\Controllers\Controller;
use App\Models\Show\Show;
use App\Models\Comment\Comment;
use App\Models\Following\Following;
use App\Models\View\View;
use App\Models\Episode\Episode;
use App\Models\Category\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AnimeController extends Controller
{
    //animeDetails
    public function animeDetails($id)
    {
        $show = Show::find($id);
        $randomShows = Show::inRandomOrder()->limit(4)
            ->where('id', '!=', $id)->get();

        $comments = Comment::select()->orderBy('id', 'desc')
            ->take(8)->where('show_id', $id)->get();


        //getting number of views
        $numberViews = View::where('show_id', $id)->count();

        //number of comments
        $numberComments = Comment::where('show_id', $id)->count();

        //getting new views

        if (isset(Auth::user()->id)) {

            //validate following shows
            $validateFollowing = Following::where('show_id', $id)
                ->where('user_id', Auth::user()->id)->count();

            //validate views
            $validateViews = View::where('show_id', $id)->where('user_id', Auth::user()->id)->count();

            if ($validateViews == 0) {

                $views = View::create([
                    "show_id" => $id,
                    "user_id" => Auth::user()->id,
                ]);
            }
            return view('anime.anime-details', compact('show', 'randomShows', 'comments', 'validateFollowing', 'numberViews', 'numberComments'));
        } else {
            return view('anime.anime-details', compact('show', 'randomShows', 'comments', 'numberViews', 'numberComments'));
        }
    }

    //storeComment
    public function storeComment(Request $request, $id)
    {

        $storeComments = Comment::create([
            "show_id" => $id,
            "user_name" => Auth::user()->name,
            "image" => Auth::user()->image,
            "comment" => $request->comment,
        ]);

        if ($storeComments) {
            // echo "Comment added success";
            return Redirect::route('anime.details', $id)->with('success', 'Comment added successfully');
        }
    }

    //follow
    public function follow(Request $request, $id)
    {
        $follow = Following::create([
            "show_id" => $id,
            "show_image" => $request->show_image,
            "show_name" => $request->show_name,
            "user_id" => Auth::user()->id,
        ]);

        if ($follow) {
            return Redirect::route('anime.details', $id)->with('follow', 'Followed successfully');
        }
    }


    //animeWatching
    public function animeWatching($show_id, $episode_id)
    {
        $show = Show::find($show_id);
        $episode = Episode::where('episode_name', $episode_id)->where('show_id', $show_id)->first();

        $episodes = Episode::select()->where('show_id', $show_id)->get();

        //comments
        $comments = Comment::select()->orderBy('id', 'desc')->take(8)->where('show_id', $show_id)->get();

        return view('shows.anime-watching', compact('show', 'episode', 'episodes', 'comments'));
    }


    //category
    public function category($category_name)
    {
        $shows = Show::select()->where('genres', $category_name)->get();

        $ForYouShows = Show::select()->orderBy('name', 'desc')->take(4)->get();

        return view('shows.category', compact('shows', 'category_name', 'ForYouShows'));
    }


    //searchShows
    public function searchShows(Request $request)
    {

        $show = $request->get('show');

        $searchShows = Show::where('name', 'like', '%' . $show . '%')
            ->orWhere('genres', 'like', '%' . $show . '%')
            ->get();

        return view('shows.searches', compact('searchShows'));
    }
}

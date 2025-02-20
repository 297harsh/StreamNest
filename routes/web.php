<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


//grouping routes for shows
Route::group(['prefix' => 'shows'], function () {

    //animeDetails
    Route::get('/show-details/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'animeDetails'])->name('anime.details');

    //comments
    Route::post('/comments-store/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'storeComment'])->name('anime.comments.store');

    //following
    Route::post('/follow/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'follow'])->name('anime.follow');

    //episodes
    Route::get('/anime-watching/{show_id}/{episode_id}', [App\Http\Controllers\Anime\AnimeController::class, 'animeWatching'])->name('anime.watching');

    //Categories
    Route::get('/category/{Category_name}', [App\Http\Controllers\Anime\AnimeController::class, 'category'])->name('anime.category');

    //search
    Route::any('/search', [App\Http\Controllers\Anime\AnimeController::class, 'searchShows'])->name('anime.search.shows');
});

//Users 
Route::get('users/followed-shows', [App\Http\Controllers\Users\UsersController::class, 'followedShows'])->name('user.followed.shows')->middleware('auth:web');




//admin panel
Route::get('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'ViewLogin'])->name('login.view')->middleware('check.for.auth');
Route::post('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'CheckLogin'])->name('login.check');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function () {
    Route::get('/dashboard', [App\Http\Controllers\Admins\AdminsController::class, 'Dashboard'])->name('admins.dashboard');

    //Admin Section
    Route::get('all-admins', [App\Http\Controllers\Admins\AdminsController::class, 'allAdmins'])->name('all.admins');
    Route::get('create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'createAdmins'])->name('create.admins');
    Route::post('create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'storeAdmins'])->name('store.admins');


    //Shows
    Route::get('all-shows', [App\Http\Controllers\Admins\AdminsController::class, 'displayAllShows'])->name('all.shows');
    Route::get('create-shows', [App\Http\Controllers\Admins\AdminsController::class, 'createShows'])->name('create.shows');
    Route::post('create-shows', [App\Http\Controllers\Admins\AdminsController::class, 'storeShows'])->name('store.shows');
    Route::get('delete-shows/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteShows'])->name('delete.shows');

    //genres
    Route::get('all-genres', [App\Http\Controllers\Admins\AdminsController::class, 'displayAllGenres'])->name('all.genres');
    Route::get('create-genres', [App\Http\Controllers\Admins\AdminsController::class, 'createGenres'])->name('create.genres');
    Route::post('create-genres', [App\Http\Controllers\Admins\AdminsController::class, 'storeGenres'])->name('store.genres');
    Route::get('delete-genres/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteGenres'])->name('delete.genres');

    //episodes
    Route::get('all-episodes', [App\Http\Controllers\Admins\AdminsController::class, 'displayAllEpisodes'])->name('all.episodes');
    Route::get('create-episodes', [App\Http\Controllers\Admins\AdminsController::class, 'createEpisodes'])->name('create.episodes');
    Route::post('create-episodes', [App\Http\Controllers\Admins\AdminsController::class, 'storeEpisodes'])->name('store.episodes');
    Route::get('delete-episodes/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteEpisodes'])->name('delete.episodes');
});

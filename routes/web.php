<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContributorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GroupMemberController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\ObjectController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfilePostController;
use App\Http\Controllers\PythonController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::resource('/dashboard', DashboardController::class);
Route::get('/dashboard/keyword/{keywords}', [DashboardController::class, 'showkeywordresult']);
Route::resource('/dashboardprofile', DashboardProfileController::class);
Route::get('/search', [SearchController::class, 'show']);

// Route::get('/profile', function () {
//     return view('profile');
// });

Route::get('/showcontributor/{postid}', [UserController::class, 'getcontributors']);
Route::resource('/profile', UserController::class)->middleware('auth');
Route::get('/finishpost', [UserController::class, 'finishpost'])->middleware('auth');
Route::get('/viewprofile/{viewprofileid}', [UserController::class, 'show']); //view profile

Route::resource('/addgroupmember', GroupController::class)->middleware('auth');
Route::resource('/groupmember', GroupMemberController::class);
Route::get('/groupmember/search', [GroupMemberController::class, 'show']); //ini ga pake

Route::get('/objects', function () {
    return view('preview_objects');
});

// Route::get('/test', function () {
//     return view('test');
// });

// Route::get('/login', function () {
//     return view('login');
// });

//for python testing (can delete later)
// Route::resource('/testpython', PythonController::class);

Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::post('/logout', [LoginController::class, 'logout']);

//nanti kasi middleware auth, untuk sementara biarin biar bisa create user
Route::get('/createuser', [RegisterController::class, 'index']);
Route::post('/createuser', [RegisterController::class, 'store']);

// Route::get('/createpost/checkSlug', [PostController::class, 'checkSlug']);
Route::get('/viewpost/{post:slug}', [PostController::class, 'show']);
Route::resource('/createpost', PostController::class)->middleware('auth');
Route::resource('/createpostfile', FileController::class);
// Route::delete('/createpostfile/{id}', [FileController::class, 'destroy'])->name('createpostfile.destroy');
Route::get('/createpostfile/{postid}', [FileController::class, 'show']);
Route::get('/viewpostfile/{fileid}', [FileController::class, 'viewpostfile']);
// Route::get('/createpostfilecontributor/{id}', [ContributorController::class, 'index']);
Route::resource('/createpostcontributor', ContributorController::class);
Route::get('/createpostfilecontributor/{postid}', [ContributorController::class, 'show']);
Route::resource('/createpostkeyword', KeywordController::class);
Route::get('/createpostkeyword/{postid}', [KeywordController::class, 'show']);

Route::resource('/createpostcontributor', ContributorController::class)->middleware('auth');
Route::resource('/createpostkeyword', KeywordController::class)->middleware('auth');

Route::resource('/createcomment', CommentController::class);

// Route::resource('user', UserController::class);

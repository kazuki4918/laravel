<?php

use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/posts/load', [HomeController::class, 'loadMore'])->name('posts.load');
Route::get('/main', [HomeController::class, 'index'])->name('main');
//Route::resource('posts', PostController::class)->only(['index', 'show']);

Route::group(['middleware' => 'auth'], function() {
  Route::post('/user/{user}/stop', [HomeController::class, 'userstop'])->name('user.stop');
  Route::post('/post/{post}/stop', [HomeController::class, 'poststop'])->name('post.stop');
  Route::post('/violations/{post}', [HomeController::class, 'storeViolation'])->name('violation.store');
  Route::get('/controls/post', [HomeController::class, 'controlPost'])->name('controls.post');
  Route::get('/controls/user', [HomeController::class, 'controlUser'])->name('controls.user');
  Route::put('/requests/{request}/status', [HomeController::class, 'updateStatus'])->name('requests.update_status');
  Route::get('requests/create/{post_id}', [HomeController::class, 'create'])->name('request.create');
  Route::get('/profiles/posts/{post}', [HomeController::class, 'showPost'])->name('profiles.posts.show');
  Route::get('/posts/load', [HomeController::class, 'loadMore'])->name('posts.load');
  Route::resource('posts', PostController::class);
  Route::resource('requests', RequestController::class);
  Route::resource('profiles', ProfileController::class);
});
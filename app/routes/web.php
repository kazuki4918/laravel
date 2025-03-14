<?php

use App\Http\Controllers\HomeController;

use App\Http\Controllers\PostController;

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

Route::get('/account/suspended', function () {
  return view('auth.suspended');
})->name('account.suspended');

// ルート設定をPOSTメソッドに変更
Route::post('/logout', function () {
  Auth::logout();
  return redirect('/login');
})->name('logout');


Route::get('/posts/load-more', [PostController::class, 'loadMore'])->name('posts.loadMore');
//Route::get('/posts/load', [PostController::class, 'loadMore'])->name('posts.load');
Route::get('/posts/index', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}/show', [PostController::class, 'show'])->name('posts.show');

Route::group(['middleware' => ['auth', 'check.status']], function () {
  Route::post('/user/{user}/stop', [HomeController::class, 'userstop'])->name('user.stop');
  Route::post('/post/{post}/stop', [HomeController::class, 'poststop'])->name('post.stop');
  Route::post('/violations/{post}', [HomeController::class, 'storeViolation'])->name('violation.store');
  Route::get('/controls/post', [HomeController::class, 'controlPost'])->name('controls.post');
  Route::get('/controls/user', [HomeController::class, 'controlUser'])->name('controls.user');
  Route::put('/requests/{request}/status', [HomeController::class, 'updateStatus'])->name('requests.update_status');
  Route::get('requests/create/{post_id}', [HomeController::class, 'create'])->name('request.create');
  Route::get('/profiles/posts/{post}', [HomeController::class, 'showPost'])->name('profiles.posts.show');
  Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
  Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
  Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
  Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
  Route::get('/posts/{post}/destroy', [PostController::class, 'destroy'])->name('posts.destroy');

  Route::resource('requests', RequestController::class);
  Route::resource('profiles', ProfileController::class);
});

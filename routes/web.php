<?php

use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignOutController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $posts = Post::query()->latest()->get();
    return view('home', [
        "title" => "Home | LaraGram",
        "posts" => $posts
    ]);
})->name('home');

Route::get("/sign-up", [SignUpController::class, 'index'])->name('sign-up');
Route::post("/sign-up", [SignUpController::class, 'store']);

Route::get("/sign-in", [SignInController::class, 'index'])->name('sign-in');
Route::post("/sign-in", [SignInController::class, 'store']);

Route::delete("/sign-out", [SignOutController::class, 'store'])->name('sign-out');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('edit-profile');
Route::put('/profile/edit', [ProfileController::class, 'update']);

Route::get('/posts/create', [PostController::class, 'create'])->name('create-post');
Route::post('/posts/create', [PostController::class, 'store']);
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('delete-post');
Route::get('/posts/edit', [PostController::class, 'edit'])->name('edit-post');
Route::put('/post/edit', [ProfileController::class, 'update']);



Route::get('/{user:username}', [UserController::class, 'index']);
Route::get('/{user:username}/posts/{post:id}', [UserController::class, 'show']);

Route::get('\link',function(){
    Artisan::call('storage:link');
});

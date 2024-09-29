<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile routes
Route::middleware(['auth'])->group(function () {
    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');    
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        //follow
        Route::post('/follow', [FollowController::class, 'follow'])->name('profile.follow');
        Route::delete('/unfollow', [FollowController::class, 'unfollow'])->name('profile.unfollow');

    //post
    Route::get('/post', [PostController::class, 'index'])->name('post.index');
    Route::get('/post/followed', [PostController::class, 'followed'])->name('post.followed');
    Route::get('/post/friend', [PostController::class, 'friend'])->name('post.friend');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');
    Route::delete('/post/delete', [PostController::class, 'destroy'])->name('post.destroy'); // <--- Added name()
        //comment
        Route::post('/comment', [CommentController::class, 'store'])->name('post.comment');
        Route::delete('/comment', [CommentController::class, 'destroy'])->name('post.comment.destroy');
        //response
        Route::post('/response', [ResponseController::class, 'store'])->name('post.response');
        Route::delete('/response', [ResponseController::class, 'destroy'])->name('post.response.destroy');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

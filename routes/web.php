<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\NotifsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    ])->group(function () {
        Route::get('/dashboard', function () {return view('/dashboard');})->name('dashboard');
        Route::resource('users', UserController::class)->only('index', 'destroy');
        Route::get('/about', function () {return view('about');})->name('about');
        // HOME---
        Route::get('/home', [HomeController::class, 'home'])->name('home');
        Route::get('/home/foryoupage', [HomeController::class, 'forYouPage'])->name('foryoupage');
        
        // PROFILE---
        Route::resource('my_profile', ProfileController::class)->only('index', 'destroy');
        Route::get('my_profile/save', [SaveController::class, 'index'])->name('saved');

        // FOLLOW/SEARCH/NOTIFICATIONS---
        Route::resource('follow', FollowController::class)->only('show', 'update', 'destroy');
        Route::get('/search', [SearchController::class, 'search'])->name('search');
        Route::get('/notifications', [NotifsController::class, 'index'])->name('notifs');

        // POST/LIKE/SAVE/COMMENT---
        Route::resource('post', PostController::class)->only('index', 'store');
        Route::post('/like/{id}', [LikeController::class, 'store'])->name('like');
        Route::post('/save/{id}', [SaveController::class, 'store'])->name('save');
        Route::post('/add_comment/{id}', [CommentController::class, 'store'])->name('comment');
});

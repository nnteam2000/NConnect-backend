<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['controller' => AuthController::class], function () {
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/register', 'register')->name('auth.register');
    Route::get('/email/verify/{id}/{hash}', 'verification')->middleware(['signed'])->name('verification.verify');

    Route::get('/auth/redirect', 'googleRedirect')->name('auth.google.redirect');
    Route::get('/auth/callback', 'googleCallback')->name('auth.google.callback');

    Route::post('/forget', 'forget')->name('password.forget');
    Route::post('/reset', 'reset')->name('password.reset');

    Route::patch('/update', 'update')->name('auth.update');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/user', 'isAuthenticated')->name('auth.user');
        Route::get('/logout', 'logout')->name('auth.logout');
    });
});


Route::group(['middleware' => 'auth:sanctum', 'controller' => PostController::class, 'prefix' => 'posts'], function () {
    Route::get('/', 'index')->name('posts.index');
    Route::get('/{post}', 'show')->name('posts.show');
    Route::post('/store', 'store')->name('posts.store');
    Route::patch('/update/{post}', 'update')->name('posts.update');
    Route::delete('/delete/{post}', 'delete')->name('posts.delete');
});

Route::group(['middleware' => 'auth:sanctum', 'controller' => CommentController::class, 'prefix' => 'comments'], function () {
    Route::get('/', 'index')->name('comment.index');
    Route::post('/store', 'store')->name('comment.store');
    Route::patch('/update/{comment}', 'update')->name('comment.update');
    Route::delete('/delete/{comment}', "delete")->name('comment.delete');
});

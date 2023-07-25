<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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
    Route::post('/register', 'register')->name('auth.register');
    Route::get('/email/verify/{id}/{hash}', 'verification')->middleware(['signed'])->name('verification.verify');

    Route::get('/auth/redirect', 'googleRedirect')->name('auth.google.redirect');
    Route::get('/auth/callback', 'googleCallback')->name('auth.google.callback');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/user', 'isAuthenticated')->name('auth.user');
        Route::post('/login', 'login')->name('auth.login');
        Route::get('/logout', 'logout')->name('auth.logout');
    });
});

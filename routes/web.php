<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('user.register');
    // return view('welcome');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/register', [UserController::class, 'create'])->name('user.register');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/webhook/google-forms', [UserController::class, 'handleGoogleFormWebhook'])->name('webhook-google-forms');
});

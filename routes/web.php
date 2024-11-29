<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController};

Route::get('/', function () {
    return to_route('user.register');
    // return view('welcome');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/register', [UserController::class,'create'])->name('user.register');
    Route::post('/store', [UserController::class,'store'])->name('user.store');
});

<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('users')->group( function () {
    Route::get('', [UserController::class, 'index']);
});
Route::resource('applications', ApplicationController::class);

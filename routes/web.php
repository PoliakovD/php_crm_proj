<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::middleware('auth.admin')->resource('users', UserController::class)->except(['show']);
Route::resource('applications', ApplicationController::class);

Auth::routes();

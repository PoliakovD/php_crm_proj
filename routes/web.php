<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::middleware('auth.admin')->resource('users', UserController::class)->except(['show']);
Route::resource('applications', ApplicationController::class)->except(['show']);

Route::middleware('auth')->group(function () {
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::patch('/gallery/{image}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{image}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
});
Route::get('/users/{user}/gallery', [GalleryController::class, 'publicGallery'])->name('gallery.public');

Auth::routes();

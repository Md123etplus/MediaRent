<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
Route::get('/', function () {
    return view(view: 'landing');
});
Route::get('/register',function(){
    return view('register.sign-up');
});
Route::get('/login',function(){
    return view('login.login');
});
Route::get('/categories',function(){
    return view('categories.main');
});
Route::get( '/search',function(){//vous pouvez changer apres
    return view('search.main');
});
Route::get( '/premium',function(){//vous pouvez changer apres
    return view('premium.main');
});
Route::get( '/blog',function(){//vous pouvez changer apres
    return view('blog.main');
});
// Routes de recherche
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/ads/{ad}', [SearchController::class, 'show'])->name('ads.show');

// Routes de réservation (nécessite authentification)
Route::middleware(['auth'])->group(function () {
    Route::get('/ads/{ad}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/ads/{ad}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
});
// Recherche
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/ads/{ad}', [SearchController::class, 'show'])->name('ads.show');

// Réservation (nécessite auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/ads/{ad}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/ads/{ad}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
});

// Gestion des catégories (si admin)
Route::apiResource('categories', CategoryController::class)->middleware('admin');
// routes/web.php
Route::get('/search', [SearchController::class, 'index'])->name('search.main');
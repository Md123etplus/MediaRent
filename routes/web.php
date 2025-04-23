<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\ObjetController;

Route::get( '/', function () {
    return view(view: 'landing');
});
Route::get('/register',function(){
    return view('register.sign-up');
})->name('register');
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

Route::get('/admin', [DashboardController::class, 'index']) ->name('admin.dashboard');
Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
// Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');

Route::post('/annonces/create', [AnnonceController::class, 'store'])->name('annonces.store');

Route::get('/annonces/index', [AnnonceController::class, 'index'])->name('annonces.index');

Route::get('/objet/create', [ObjetController::class, 'create'])->name('objet.create');
Route::post('/objet/store', [ObjetController::class, 'store'])->name('objet.store');

Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])
    ->name('annonces.show');

    Route::get('/mes-annonces', [AnnonceController::class, 'mesAnnonces']);
    Route::post('/annonce/{id}/archiver', [AnnonceController::class, 'archiver'])->name('annonce.archiver');


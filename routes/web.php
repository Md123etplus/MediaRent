<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
// Duplicate import removed
use App\Http\Controllers\ObjetController;
use App\Http\Controllers\PartenaireDashboardController;
use App\Http\Controllers\AnnonceController;
// use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Routes publiques
Route::get('/', function () {
    return view('landing');
})->name('home');
Route::get('/premium', function () {
    return view('premium.main');
})->name('premium');

Route::get('/register', function () {
    return view(view: 'register.sign-up');
})->name('register');;
Route::get('/login',function(){
    return view('login.login');
});
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/categories',function(){
    return view('categories.main');
})->name('categories');

Route::get('/search', function () {
    return view('search.main');
})->name('search');



Route::get('/blog', function () {
    return view('blog.main');
})->name('blog');


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


// Annonces (accessibles à tous)
Route::get('/annonces', [AnnonceController::class, 'index'])
     ->name('annonces.index');

// Espace partenaire
// middleware(['auth'])
Route::prefix('partenaire')->name('partenaire.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PartenaireDashboardController::class, 'index'])
        ->name('dashboard');
    
    // Gestion des disponibilités
    Route::get('/partenaire/disponibilites', [PartenaireDashboardController::class, 'disponibilites'])
    ->name('partenaire.disponibilites');
    // Gestion des annonces
    Route::put('/annonce/{id}/restore', [PartenaireDashboardController::class, 'restaurerAnnonce'])
        ->name('annonce.restore');
    
    // Réservations
    Route::get('/reservations', [PartenaireDashboardController::class, 'reservations'])
        ->name('reservations');
        Route::get('/disponibilites', [PartenaireDashboardController::class, 'disponibilites'])
        ->name('disponibilites');

    // Routes pour les annonces
    Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
    Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
        
     // Routes pour les objets
     Route::get('/objets/create', [ObjetController::class, 'create'])->name('objets.create');
     Route::get('/objets', [ObjetController::class, 'index'])->name('objets.index');
});

// Gestion des annonces (réservée aux partenaires)
// middleware(['auth'])->
Route::prefix('annonces')->name('annonces.')->group(function () {
    Route::get('/create', [AnnonceController::class, 'create'])->name('create');
    Route::post('/', [AnnonceController::class, 'store'])->name('store');
});

// Route de test (à supprimer en production)
Route::get('/connexion-test', function () {
    $user = User::find(2); // <--- ici, c'est bien l'utilisateur ID 2
    if ($user) {
        Auth::login($user);
        return redirect()->route('partenaire.dashboard');
    }
    return redirect('/')->with('error', value: 'Utilisateur de test non trouvé');
});

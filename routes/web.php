<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ObjetController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnnonceController;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

// Page d'accueil
Route::get('/', function () {
    return view('landing');
})->name('landing');


// Routes pour les réservations
Route::get('/reservations/create/{annonce}', [ReservationController::class, 'reserverForm'])->name('reservations.form');
Route::post('/reservations/store/{annonce}', [ReservationController::class, 'store'])->name('reservations.store');

// Routes pour l'inscription et la connexion
Route::get('/register', function () {
    return view('register.sign-up');
});
Route::get('/login', function () {
    return view('login.login');
});

// Routes pour les catégories
Route::get('/categories', [CategorieController::class, 'index'])->name('categories.index');

// Routes pour la recherche d'annonces
Route::get('/search', [SearchController::class, 'index'])->name('search');


// Routes pour les objets
Route::get('/objets', [ObjetController::class, 'index'])->name('objets.index');
Route::get('/objets/{id}', [ObjetController::class, 'show'])->name('objets.show');

// Routes pour les évaluations
Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');

// Routes pour les réclamations
Route::get('/reclamations', [ReclamationController::class, 'index'])->name('reclamations.index');
Route::post('/reclamations/index', [ReclamationController::class, 'store'])->name('reclamations.store');

// Routes pour la gestion des utilisateurs
Route::get('/utilisateur/inscription', [UtilisateurController::class, 'create'])->name('utilisateur.create');
Route::post('/utilisateur/store', [UtilisateurController::class, 'store'])->name('utilisateur.store');
Route::get('/utilisateur/{id}', [UtilisateurController::class, 'show'])->name('utilisateur.show');

// Liste des réservations du client
Route::get('/mes-reservations', [ReservationController::class, 'mesReservations'])->name('client.reservations.index');

// Routes pour la réservation d'annonces
Route::get('/annonce/{annonce}/reserver', [ReservationController::class, 'reserverForm'])->name('reservations.form');
//login
Route::post('/annonce/{annonce}/reserver', [ReservationController::class, 'store'])->name('reservations.store');


Route::get('/landing', function () {
    return view('landing');
});

// Afficher le formulaire de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Traiter la connexion
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/annonce/{annonce}/reserver', [ReservationController::class, 'reserverForm'])
         ->name('reservations.form');
    Route::post('/annonce/{annonce}/reserver', [ReservationController::class, 'store'])
         ->name('reservations.store');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});



Route::get('/annonces/{annonce}/reservations', [ReservationController::class, 'create'])
->name('reservations.create');
 Route::post('/annonces/{annonce}/reservations', [ReservationController::class, 'store'])
         ->name('reservations.store');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');



Route::get('/annonces/{annonce}/reserver', [ReservationController::class, 'showForm'])
    ->name('annonces.reserver');
 // web.php

   

// OU version alternative (sans paramètre de route)
Route::post('/reservations', [ReservationController::class, 'store'])
->name('reservations.store');

Route::get('/reservations/confirmation', function () {
    return view('reservations.confirmation');
})->name('reservations.confirmation');

//formClient

use App\Http\Controllers\ClientController;

Route::get('/reservations/formClient', [ClientController::class, 'create'])->name('reservations.formClient');
Route::post('/reservations/formClient', [ClientController::class, 'store'])->name('reservations.storeClient');

Route::get('/reservations/reponse/{id}/{decision}', [ReservationController::class, 'reponse'])->name('reservations.reponse');




//Route::get('/test-email', function () {
  //  Mail::raw('Bonjour, ceci est un test Mailtrap !', function ($message) {
     //   $message
        //    ->to('mediarent@gmail.com')   // remplacez par bounoua.marwa@etu.uae.ac.ma
          //  ->subject('Test d’envoi via Mailtrap');
    //});
    //return 'Email de test envoyé (ou en échec silencieux) !';
//});







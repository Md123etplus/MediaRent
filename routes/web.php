<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
// Duplicate import removed
// use App\Http\Controllers\ObjetController;
// use App\Http\Controllers\PartenaireDashboardController;
// use App\Http\Controllers\AnnonceController;
// use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Routes publiques
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ObjetController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\Client\EvaluationController;
use App\Http\Controllers\PartenaireDashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Client\CReservationController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnnonceController;
// use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Page d'accueiluse Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Client\DashboardController;
// use App\Http\Controllers\Client\ReservationController;
// use App\Http\Controllers\Client\EvaluationController;
use App\Http\Controllers\Client\NotificationController;
// use App\Models\Utilisateur;

// Routes publiques
Route::get('/dashboard/client', function () {
    return view('client.index');
})->name('client.index');

// Route::get('/register', function() {
//     return view('register.sign-up');
// })->name('register');

Route::get('/', function() {
    return view('landing');
})->name('home');
Route::get('/premium', function () {
    return view('premium.main');
})->name('premium');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
// Route::get('/register', function () {
//     return view(view: 'register.register');
// })->name('register');;
// Route::get('/login',function(){
//     return view('landing');
// })->name('landing');


// Routes pour les réservations
Route::get('/reservations/create/{annonce}', [ReservationController::class, 'reserverForm'])->name('reservations.form');
Route::post('/reservations/store/{annonce}', [ReservationController::class, 'store'])->name('reservations.store');

// Routes pour l'inscription et la connexion
// Route::get('/register', function () {
//     return view('register.sign-up');
// });
Route::get('/login', function () {
    return view('login.login');
});
/*
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
*/
Route::get('/categories',function(){
    return view('categories.main');
})->name('categories');

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/search', function () {
    return view('search.main');
})->name('search');



Route::get('/blog', function () {
    return view('blog.main');
})->name('blog');


Route::prefix('admin')->group(function () { //->middleware(['auth', 'admin'])
    Route::get('/', [DashboardController::class, 'index']) ->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/users/{user}/toggle-suspension', [UserController::class, 'toggleSuspension'])
         ->name('admin.users.toggle-suspension');
    // ... autres routes admin
});
Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
// Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');

Route::post('/annonces/create', [AnnonceController::class, 'store'])->name('annonces.store');

Route::get('/annonces/index', [AnnonceController::class, 'index'])->name('annonces.index');

Route::get('/objet/create', [ObjetController::class, 'create'])->name('objet.create');
Route::post('/objet/store', [ObjetController::class, 'store'])->name('objet.store');

Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])
    ->name('annonces.show');


    Route::get('/mes-annonces', [AnnonceController::class, 'mesAnnonces'])
    ->name('annonces.mes_annonces');
  

// Route pour archiver (POST)
Route::post('/mes-annonces/{annonce}/archive', [AnnonceController::class, 'archiver'])
    ->name('annonces.archive');
   

// Route pour restaurer (POST)
Route::post('/mes-annonces/{annonce}/restore', [AnnonceController::class, 'restore'])
    ->name('annonces.restore');


     

Route::get('/annonces/{annonce}/reserver', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');


Route::get('/annonces', [AnnonceController::class, 'Annonces'])->name('annonces.annonces');


Route::get('/mes-objets', [ObjetController::class, 'mesObjets'])->name('objet.mes_objets');






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
        Route::put('/partenaire/annonces/{id}/restore', [PartenaireDashboardController::class, 'restaurerAnnonce'])
        ->name('partenaire.annonce.restore');
    // Réservations
    Route::get('/reservations', [PartenaireDashboardController::class, 'reservations'])
        ->name('reservations');
        Route::get('/disponibilites', [PartenaireDashboardController::class, 'disponibilites'])
        ->name('disponibilites');

    // Routes pour les annonces
    Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
    Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
        
    Route::get('/partenaire', [PartenaireDashboardController::class, 'index'])->name('partenaire.index');
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


// Route::get('/landing', function () {
//     return view('landing');
// });

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

Route::get('/recherche', [AnnonceController::class, 'search'])->name('annonces.search');





// Routes client avec protection standard
Route::prefix('client')->name('client.')->group(function() {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Réservations
    Route::prefix('reservations')->name('reservations.')->group(function() {
        Route::get('/', [CReservationController::class, 'index'])->name('index');
        Route::get('/{reservation}', [CReservationController::class, 'show'])->name('show');
        Route::delete('/{reservation}/cancel', [CReservationController::class, 'cancel'])->name('cancel');
    });
    
    // Évaluations
    Route::prefix('evaluations')->name('evaluations.')->group(function() {
        Route::get('/', [EvaluationController::class, 'index'])->name('index');
        Route::get('/create/{reservation}', [EvaluationController::class, 'create'])->name('create');
        Route::post('/store/{reservation}', [EvaluationController::class, 'store'])->name('store');
        Route::get('/{evaluation}', [EvaluationController::class, 'show'])->name('show');
        Route::get('/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('edit');
        Route::put('/{evaluation}', [EvaluationController::class, 'update'])->name('update');
    });
    
    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function() {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
    });

    // Ajoutez cette route dans votre fichier routes/web.php
Route::get('/recherche', [AnnonceController::class, 'search'])->name('annonces.search');

    // Route de test (uniquement en développement)
    if (app()->environment('local')) {
        Route::get('/switch-to-default', function() {
            $defaultUser = User::firstOrCreate(
                ['id' => 2],
                [
                    'nom' => 'Default',
                    'prenom' => 'User',
                    'email' => 'default.user@example.com',
                    'mot_de_passe' => bcrypt('password'),
                    'role' => 'client',
                    'CIN' => 'EE123456',
                    'img_profil' => '/images/default-profile.png',
                    'img_cin_front' => '/images/default-cin-front.jpg',
                    'img_cin_back' => '/images/default-cin-back.jpg'
                ]
            );
            Auth::login($defaultUser);
            return redirect()->route('client.dashboard');
        })->name('switch.default');
    }
});
//newsletter
Route::get('/newsletter/confirm/{token}', [NewsletterController::class, 'confirm'])->name('newsletter.confirm');
Route::get('/offline', function () {
    return view('offline');
    });
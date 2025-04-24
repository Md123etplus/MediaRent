<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\ReservationController;
use App\Http\Controllers\Client\EvaluationController;
use App\Http\Controllers\Client\NotificationController;
use App\Models\Utilisateur;

// Routes publiques
Route::get('/', function () {
    return view('client.index');
});

Route::get('/register', function() {
    return view('register.sign-up');
})->name('register');

Route::get('/login', function() {
    return view('login.login');
})->name('login');

Route::get('/categories', function() {
    return view('categories.main');
});

Route::get('/search', function() {
    return view('search.main');
});

Route::get('/premium', function() {
    return view('premium.main');
});

Route::get('/blog', function() {
    return view('blog.main');
});

// Routes client avec protection standard
Route::prefix('client')->name('client.')->group(function() {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Réservations
    Route::prefix('reservations')->name('reservations.')->group(function() {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/{reservation}', [ReservationController::class, 'show'])->name('show');
        Route::delete('/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('cancel');
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

    // Route de test (uniquement en développement)
    if (app()->environment('local')) {
        Route::get('/switch-to-default', function() {
            $defaultUser = Utilisateur::firstOrCreate(
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
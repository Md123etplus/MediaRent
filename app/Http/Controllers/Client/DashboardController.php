<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Si l'utilisateur n'est pas connecté, retourne des valeurs par défaut
    if (!$user) {
        $ongoingReservations = 0;
        $pastReservations = 0;
        $evaluations = new LengthAwarePaginator([], 0, 10);

        return view('client.index', compact('ongoingReservations', 'pastReservations', 'evaluations'));
    }
        // Réservations en cours
        $ongoingReservations = $user->reservations()
            ->where('statut', 'confirmée')
            ->where('date_fin', '>=', Carbon::today())
            ->count();
        
        // Réservations passées
        $pastReservations = $user->reservations()
            ->where(function($query) {
                $query->where('statut', 'terminée')
                      ->orWhere('date_fin', '<', Carbon::today());
            })
            ->count();
        
        // Note moyenne des évaluations
        $averageRating = $user->evaluations()
            ->where('evaluateur_id', $user->id)
            ->avg('note');
        
        // Réservations récentes
        $recentReservations = $user->reservations()
            ->with(['annonce.objet.images', 'annonce.proprietaire'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            return view('client.index', [
                'recentReservations' => $recentReservations,
            ]);
        // Notifications non lues
        $notifications = $user->notifications()
            ->orderBy('date_creation', 'desc')
            ->take(5)
            ->get();

            return view('client.index', [
                'ongoingReservations' => $ongoingReservations,
                'pastReservations' => $pastReservations,
                'averageRating' => $averageRating ?? 0, // Default to 0 if null
                'recentReservations' => $recentReservations,
                'notifications' => $notifications
            ]);
        }
    }
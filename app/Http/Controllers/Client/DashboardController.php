<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Evaluation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return view('client.index', [
                'ongoingReservations' => 0,
                'pastReservations' => 0,
                'averageRating' => 0,
                'evaluationsCount' => 0,
                'recentReservations' => collect()
            ]);
        }
        
        // 1. Réservations en cours (statut en_attente et date non passée)
        $ongoingReservations = $user->reservations()
            ->where('statut', 'en_attente')
            ->where('date_fin', '>=', Carbon::today())
            ->count();
        
        // 2. Réservations passées (statut confirmée OU terminée)
        $pastReservations = $user->reservations()
            ->whereIn('statut', ['confirmée', 'terminée'])
            ->count();
        
        // 3. Note moyenne et nombre d'évaluations
        $evaluations = $user->evaluations()
            ->where('evaluateur_id', $user->id)
            ->selectRaw('AVG(note) as average, COUNT(*) as count')
            ->first();
        
        $averageRating = $evaluations->average ?? 0;
        $evaluationsCount = $evaluations->count ?? 0;
        
        // Réservations récentes (tous statuts sauf annulée)
        $recentReservations = $user->reservations()
            ->where('statut', '!=', 'annulée')
            ->with(['annonce.objet.images', 'annonce.proprietaire'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('client.index', [
            'ongoingReservations' => $ongoingReservations,
            'pastReservations' => $pastReservations,
            'averageRating' => round($averageRating, 1),
            'evaluationsCount' => $evaluationsCount,
            'recentReservations' => $recentReservations
        ]);
    }
}
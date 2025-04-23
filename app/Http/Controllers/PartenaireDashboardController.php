<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Annonce;
use App\Models\Objet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PartenaireDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user || $user->role !== 'partenaire') {
            abort(403, 'Accès réservé aux partenaires');
        }
    
        // Chargement optimisé des relations
        $annonces = Annonce::with(['objet.categorie', 'reservations' => function($query) {
            $query->where('statut', 'confirmée');
        }])
        ->where('proprietaire_id', $user->id)
        ->get();
    
        // Calcul du revenu
        $revenuTotal = 0;
        $joursOccupes = 0;
        
        foreach ($annonces as $annonce) {
            foreach ($annonce->reservations as $reservation) {
                $jours = Carbon::parse($reservation->date_debut)->diffInDays($reservation->date_fin) + 1;
                $revenuTotal += $jours * $annonce->objet->prix_journalier;
                $joursOccupes += $jours;
            }
        }
    
        $tauxOccupation = $joursOccupes > 0 ? min(100, ($joursOccupes / 30) * 100) : 0;
//dd([
//    'annonces' => $annonces->toArray(),
//    'reservations_count' => $annonces->sum(fn($a) => $a->reservations->count()),
//    'revenu_calcul' => $revenuTotal
//]);
        return view('dashboard.partenaire.index', [
            'revenuTotal' => $revenuTotal,
            'nombreReservations' => $annonces->sum(fn($a) => $a->reservations->count()),
            'annoncesActives' => $annonces->where('statut', 'active')->count(),
            'annoncesArchives' => $annonces->where('statut', 'archivée'),
            'tauxOccupation' => round($tauxOccupation)
        ]);
    }
    public function disponibilites()
    {
        $user = Auth::user();
        $events = Annonce::where('proprietaire_id', $user->id)
            ->get()
            ->map(function ($annonce) {
                return [
                    'id' => $annonce->id,
                    'title' => $annonce->objet->nom,
                    'start' => $annonce->date_debut->format('Y-m-d'), // Format ISO sans timezone
                    'end' => Carbon::parse($annonce->date_fin)->addDay()->format('Y-m-d'), // FullCalendar nécessite un jour supplémentaire
                    'color' => $annonce->premium ? '#8B5CF6' : '#3B82F6',
                    'extendedProps' => [
                        'statut' => $annonce->statut
                    ]
                ];
            });
    
        return response()->json($events);
    }
    public function toggleAnnonce($id)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'partenaire') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $annonce = Annonce::with('objet')
            ->where('id', $id)
            ->where('proprietaire_id', $user->id)
            ->firstOrFail();

        $newStatus = $annonce->statut === 'archivée' ? 'active' : 'archivée';
        
        $annonce->update(['statut' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => "Annonce {$annonce->objet->nom} marquée comme {$newStatus}",
            'new_status' => $newStatus,
            'annonce_id' => $annonce->id
        ]);
    }

    public function reservations()
    {
        $user = auth()->user();
        
        if (!$user || $user->role !== 'partenaire') {
            abort(403, 'Accès réservé aux partenaires');
        }

        $reservations = Reservation::with(['annonce.objet.categorie', 'client'])
            ->whereHas('annonce', function($query) use ($user) {
                $query->where('proprietaire_id', $user->id);
            })
            ->orderBy('date_debut', 'desc')
            ->paginate(10);

        $revenuTotal = $reservations->sum(function($r) {
            $jours = Carbon::parse($r->date_debut)->diffInDays($r->date_fin) + 1;
            return $jours * ($r->annonce->objet->prix_journalier ?? 0);
        });

        return view('dashboard.partenaire.reservations', [
            'reservations' => $reservations,
            'revenuTotal' => $revenuTotal
        ]);
    }

    public function updateDisponibilite(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'partenaire') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut'
        ]);

        $annonce = Annonce::where('id', $id)
            ->where('proprietaire_id', $user->id)
            ->firstOrFail();

        $annonce->update([
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Disponibilité mise à jour avec succès'
        ]);
    }
}
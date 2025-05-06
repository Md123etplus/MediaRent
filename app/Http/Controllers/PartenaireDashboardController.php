<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Annonce;
use App\Models\Objet;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PartenaireDashboardController extends Controller
{
    public function index()
    {
        // $user = Auth::user();
        $user = User::find(Auth::id()); // Replace 1 with your test user's ID

        // if (!$user || $user->role !== 'partenaire') {
        //     abort(403, 'Accès réservé aux partenaires');
        // }
    
        // Chargement optimisé des relations
        $annonces = Annonce::with(['objet.categorie', 'reservations' => function($query) {
            $query->where('statut', 'confirmée');
        }])
        ->where('proprietaire_id', $user->id)
        ->get();
    
        // Calcul du revenu
        $revenuTotal = 0;
        $joursOccupes = 0;
        $nombreReservations = 0; // Initialisation ajoutée
        
        foreach ($annonces as $annonce) {
            $nombreReservations += $annonce->reservations->count(); // Calcul du nombre de réservations
            foreach ($annonce->reservations as $reservation) {
                $jours = Carbon::parse($reservation->date_debut)->diffInDays($reservation->date_fin) + 1;
                $revenuTotal += $jours * $annonce->objet->prix_journalier;
                $joursOccupes += $jours;
            }
        }
    
        // Calcul des autres variables nécessaires
        $annoncesActives = $annonces->where('statut', 'active')->count();
        $totalAnnonces = $annonces->count();
        $joursDisponibles = $totalAnnonces * 30; // Approximation - 30 jours par annonce
        $tauxOccupation = $joursOccupes > 0 ? min(100, ($joursOccupes / $joursDisponibles) * 100) : 0;
        
        // Annonces archivées
        $annoncesArchives = Annonce::where('proprietaire_id', $user->id)
            ->where('statut', 'archivée')
            ->with('objet.categorie')
            ->get();
    
        // Objets pour le modal
        $objets = Objet::where('proprietaire_id', $user->id)->get();
    
        // Réservations pour le calendrier
        $reservations = Reservation::whereHas('annonce', function($query) use ($user) {
                $query->where('proprietaire_id', $user->id);
            })
            ->with(['annonce.objet', 'client'])
            ->get();
    
        return view('dashboard.partenaire.index', compact(
            'revenuTotal',
            'nombreReservations',
            'annoncesActives',
            'totalAnnonces',
            'tauxOccupation',
            'joursOccupes',
            'joursDisponibles',
            'annoncesArchives',
            'reservations',
            'objets'
        ));
    }

    
    public function restaurerAnnonce($id)
    {
        $annonce = Annonce::onlyTrashed()->findOrFail($id);
        $annonce->restore();

        return redirect()->route('partenaire.annonces.index')
            ->with('success', 'Annonce restaurée avec succès');
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
        $user = Auth::user();
        
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
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
        $user = User::find(Auth::id());

        // if (!$user || $user->role !== 'partenaire') {
        //     abort(403, 'Accès réservé aux partenaires');
        // }

        // Chargement optimisé des relations
        $annonces = Annonce::with(['objet.categorie', 'reservations' => function ($query) {
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
            ->whereIn('statut', ['inactive', 'archivée'])  // Cherche les deux statuts
            ->with('objet.categorie')
            ->get();

        // Objets pour le modal
        $objets = Objet::where('proprietaire_id', $user->id)->get();

        // Réservations pour le calendrier
        $reservations = Reservation::whereHas('annonce', function ($query) use ($user) {
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
        $user = Auth::user();

        // Recherchez l'annonce (sans withTrashed/onlyTrashed)
        $annonce = Annonce::where('id', $id)
            ->where('proprietaire_id', $user->id)
            ->firstOrFail();

        // Vérifiez si l'annonce est archivée/inactive
        if (in_array($annonce->statut, ['archivée', 'inactive'])) {
            // Restaurez en mettant le statut à 'active'
            $annonce->update(['statut' => 'active']);

            return redirect()->route('partenaire.annonces.index')
                ->with('success', 'Annonce restaurée avec succès');
        }

        return redirect()->back()
            ->with('error', "Cette annonce n'était pas archivée");
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

        // Modification ici pour gérer 'inactive' et 'archivée'
        $newStatus = in_array($annonce->statut, ['archivée', 'inactive'])
            ? 'active'
            : 'inactive'; // Vous pouvez mettre 'archivée' si vous préférez

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
            ->whereHas('annonce', function ($query) use ($user) {
                $query->where('proprietaire_id', $user->id);
            })
            ->orderBy('date_debut', 'desc')
            ->paginate(10);

        $revenuTotal = $reservations->sum(function ($r) {
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
        $validated = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'objet_id' => 'required|exists:objets,id'
        ]);

        // Utilisez updateOrCreate pour éviter de créer des doublons
        $annonce = Annonce::updateOrCreate(
            ['id' => $id],
            [
                'date_debut' => $validated['date_debut'],
                'date_fin' => $validated['date_fin'],
                'objet_id' => $validated['objet_id'],
                'proprietaire_id' => Auth::id(),
                'statut' => 'disponible' // Nouveau statut
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Disponibilité enregistrée',
            'event' => [
                'id' => $annonce->id,
                'title' => 'Dispo: ' . $annonce->objet->nom,
                'start' => $annonce->date_debut->format('Y-m-d'),
                'end' => $annonce->date_fin->format('Y-m-d'),
                'color' => '#10B981' // Couleur verte
            ]
        ]);
    }
    public function livraisons()
    {
        // Récupérer l'ID du partenaire connecté
        $partenaireId = Auth::id();

        // Récupérer toutes les réservations avec livraison pour les annonces du partenaire
        $livraisons = Reservation::with(['annonce.objet', 'client'])
            ->whereHas('annonce', function ($query) use ($partenaireId) {
                $query->where('proprietaire_id', $partenaireId);
            })
            ->where('livraison', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.partenaire.livraisons', compact('livraisons'));
    }

    public function repondreLivraison($id, $reponse)
    {
        $reservation = Reservation::findOrFail($id);

        // Vérifier que le partenaire est bien le propriétaire de l'annonce
        if ($reservation->annonce->proprietaire_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }

        switch ($reponse) {
            case 'accepter':
                $reservation->statut_livraison = 'en_cours';
                break;
            case 'refuser':
                $reservation->statut_livraison = 'refusée';
                $reservation->livraison = false;
                $reservation->frais_livraison = 0;
                break;
            case 'livre':
                $reservation->statut_livraison = 'livrée';
                // Vous pouvez ajouter ici d'autres actions comme l'envoi d'un email au client
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Action non valide'], 400);
        }

        $reservation->save();

        // Retourner une réponse JSON pour l'API
        return response()->json([
            'success' => true,
            'message' => 'Statut de livraison mis à jour',
            'statut' => $reservation->statut_livraison
        ]);
    }
    public function livraisonDetails($id)
    {
        $reservation = Reservation::with(['annonce.objet', 'client'])
            ->where('id', $id)
            ->whereHas('annonce', function ($query) {
                $query->where('proprietaire_id', Auth::id());
            })
            ->firstOrFail();

        return view('dashboard.partenaire.livraison-details', compact('reservation'));
    }
}

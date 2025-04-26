<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\User;

class CReservationController extends Controller
{
    
    
        
        public function index(Request $request)
{
    // $clientId = 2;
    // $query = \App\Models\User::find($clientId)
    //     ->reservations()
    //     ->with([
    //         'annonce.objet.images', 
    //         'annonce.proprietaire',
    //         'evaluation' // Charger l'évaluation liée
    //     ])
    //     ->orderBy('created_at', 'desc');
    $query = \App\Models\User::find(Auth::id())
    ->reservations()
    ->with([
        'annonce.objet.images', 
        'annonce.proprietaire',
        'evaluation' // Charger l'évaluation liée
    ])
    ->orderBy('created_at', 'desc');
            
        // Ajout des filtres
        if ($request->has('search')) {
            $query->whereHas('annonce.objet', function($q) use ($request) {
                $q->where('nom', 'like', '%'.$request->search.'%');
            });
        }
        
        if ($request->has('status')) {
            $query->where('statut', $request->status);
        }
        
        if ($request->has('date_from')) {
            $query->where('date_debut', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->where('date_fin', '<=', $request->date_to);
        }
        
        $recentReservations = $query->paginate(10);
        
        return view('client.reservations.index', compact('recentReservations'));
    }

    public function show(Reservation $reservation)
    {
        // Vérifier que la réservation appartient bien à l'utilisateur connecté
        if ($reservation->client_id !== Auth::id()) {
            abort(403);
        }
        
        $ownerAverageRating = $reservation->annonce->proprietaire->evaluations()
            ->avg('note_proprietaire');
            
        $ownerRatingsCount = $reservation->annonce->proprietaire->evaluations()
            ->count();
        
        return view('client.reservations.show', compact(
            'reservation',
            'ownerAverageRating',
            'ownerRatingsCount'
        ));
    }

    public function cancel(Reservation $reservation)
    {
        // Vérifier que la réservation appartient bien à l'utilisateur connecté
        if ($reservation->client_id !== Auth::id()) {
            abort(403);
        }
        
        // Vérifier que la réservation peut être annulée
        if ($reservation->statut !== 'en attente') {
            return back()->with('error', 'Seules les réservations en attente peuvent être annulées.');
        }
        
        // Annuler la réservation
        $reservation->update(['statut' => 'annulée']);
        
        // Envoyer une notification au propriétaire
        
        return redirect()->route('client.reservations.index')
            ->with('success', 'La réservation a été annulée avec succès.');
    }
}
   
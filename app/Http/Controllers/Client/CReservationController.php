<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon; 

class CReservationController extends Controller
{
    
    
        
    public function index(Request $request)
    {
        $query = Auth::user()->reservations()
            ->with([
                'annonce.objet.images', 
                'annonce.proprietaire',
                'evaluation' // ⛔️ Retirer le where ici !
            ])
            ->orderBy('created_at', 'desc');
    
        // Filtre par recherche texte
        if ($request->filled('search')) {
            $query->whereHas('annonce.objet', function($q) use ($request) {
                $q->where('nom', 'like', '%'.$request->search.'%')
                  ->orWhere('ville', 'like', '%'.$request->search.'%');
            });
        }
    
        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('statut', $request->status);
        }
    
        if ($request->filled('date_from')) {
            $dateFrom = Carbon::parse($request->date_from)->startOfDay();
            $query->where('date_debut', '>=', $dateFrom);
        }
        
      
        // Ajoutez cette ligne pour voir la requête SQL générée (debug)
        // \Log::debug($query->toSql());
    
        $recentReservations = $query->paginate(10)
            ->appends($request->query());
    
        return view('client.reservations.index', compact('recentReservations'));
    }
    
    public function show(Reservation $reservation)
    {
        // Vérifier que la réservation appartient bien à l'utilisateur connecté
        if ($reservation->client_id !== Auth::id()) {
            abort(403);
        }
        
        $ownerAverageRating = $reservation->annonce->proprietaire->evaluations()
            ->avg('note');
            
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
        if ($reservation->statut !== 'en_attente') {
            return back()->with('error', 'Seules les réservations en attente peuvent être annulées.');
        }
        
        // Annuler la réservation
        $reservation->update(['statut' => 'annulée']);
        
        // Envoyer une notification au propriétaire
        
        return redirect()->route('client.reservations.index')
            ->with('success', 'La réservation a été annulée avec succès.');
    }
}
   
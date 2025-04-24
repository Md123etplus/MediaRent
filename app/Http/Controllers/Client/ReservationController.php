<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = optional(Auth::user())->reservations()
    ? Auth::user()->reservations()
        ->with(['annonce.objet.images', 'annonce.proprietaire'])
        ->orderBy('created_at', 'desc')
        ->paginate(10)
    : collect();
            
        return view('client.reservations.index', compact('reservations'));
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
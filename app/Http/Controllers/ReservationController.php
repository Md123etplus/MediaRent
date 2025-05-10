<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Annonce;
use App\Models\User;
use Illuminate\Http\Request;
// use App\Models\Utilisateur; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NouvelleReservation;
use App\Mail\ReservationAccepted;
use App\Mail\ReservationRejected;



class ReservationController extends Controller
{
    public function create($annonceId)
    {
        $annonce = Annonce::findOrFail($annonceId);
        return view('reservations.create', compact('annonce'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);
    
        $annonce = Annonce::with(['proprietaire', 'objet'])->findOrFail($request->input('annonce_id'));
    
        $reservation = Reservation::create([
            'annonce_id' => $annonce->id,
            'client_id' => Auth::id() , 
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
            'statut' => 'en_attente'
        ]);
    
        // Envoi email au propriétaire
        $this->sendReservationEmail($reservation, $annonce);
    
        return redirect()->route('reservations.formClient')
               ->with('success', 'Réservation enregistrée! Remplissez vos informations.');
    }
    
    private function sendReservationEmail(Reservation $reservation, Annonce $annonce)
    {
        $proprietaire = $annonce->proprietaire; 
        $client = Auth::user(); 
    
        if ($proprietaire && $proprietaire->email) {
            Mail::to($proprietaire->email)->send(
                new NouvelleReservation(
                    $reservation,
                    $annonce,
                    $client
                )
            );
        }
    }


public function storeDates(Request $request, Annonce $annonce)
{
    $validated = $request->validate([
        'date_debut' => 'required|date|after_or_equal:today',
        'date_fin' => 'required|date|after:date_debut'
    ]);

    // Calcul du prix total
    $jours = $validated['date_debut']->diffInDays($validated['date_fin']);
    $prixTotal = $annonce->objet->prix_journalier * $jours;

    // Stockage en session
    session([
        'reservation_data' => [
            'annonce_id' => $annonce->id,
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'],
            'prix_total' => $prixTotal
        ]
    ]);

    return redirect()->route('reservations.formClient');
}



public function respond(Request $request, $id, $response)
{
    $reservation = Reservation::with(['annonce.objet', 'annonce.proprietaire', 'client'])
                     ->findOrFail($id);

    if (!in_array($response, ['accept', 'reject'])) {
        return back()->with('error', 'Action invalide');
    }

    // Mise à jour du statut
    $reservation->statut = ($response === 'accept') ? 'confirmée' : 'annulée';
    $reservation->save();

    // Envoi de l'email approprié
    $mailClass = ($response === 'accept') 
        ? ReservationAccepted::class 
        : ReservationRejected::class;

    Mail::to($reservation->client->email)
        ->send(new $mailClass($reservation, $reservation->annonce));

    return back()->with('success', 
        ($response === 'accept')
            ? 'Réservation acceptée et client notifié'
            : 'Réservation refusée et client notifié'
    );
}


    
}
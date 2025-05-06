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
            'statut' => 'required|in:en_attente,confirme,annule',
        ]);
    
        $annonce = Annonce::findOrFail($request->input('annonce_id'));
    
        $reservation = new Reservation();
        $reservation->annonce_id = $annonce->id;
        $reservation->client_id = Auth::id(); // utilisateur connecté//Auth::id()
        $reservation->date_debut = $request->input('date_debut');
        $reservation->date_fin = $request->input('date_fin');
        $reservation->statut = 'en_attente';
        $reservation->save();
    
        // Récupérer le propriétaire de l'annonce
        $partenaire = $annonce->proprietaire;
    
        // Récupérer le client connecté
        $utilisateur = User::findOrFail(2); // Auth::user(); // Utilisateur connecté
    
        // Envoi de l'email
        if ($partenaire && $partenaire->email) {
            Mail::to($partenaire->email)->send(
                new \App\Mail\NouvelleReservation(
                    $reservation,
                    $utilisateur,
                    $annonce
                )
            );
        }
    
        return redirect()->route('reservations.formClient')
            ->with('success', 'Réservation enregistrée, veuillez remplir vos informations personnelles.');
    }
    

    public function showForm($id)
    {
        $annonce = Annonce::findOrFail($id);
        return view('reservations.create', compact('annonce'));
    }
//reponse a lemail du client
    public function reponse($id, $decision)
{
    $reservation = Reservation::findOrFail($id);

    // Vérification de décision
    if (!in_array($decision, ['accepter', 'refuser'])) {
        return redirect()->route('home')->with('error', 'Décision invalide.');
    }

    // Mise à jour du statut
    $reservation->statut = ($decision === 'accepter') ? 'confirme' : 'annule';
    $reservation->save();

    // Optionnel : Notifier le client ?
    // Mail::to($reservation->client->email)->send(new ReponseReservation(...));

    return redirect()->route('landing')->with('success', 'Vous avez bien ' . ($decision === 'accepter' ? 'accepté' : 'refusé') . ' la réservation.');
}

    
}
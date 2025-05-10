<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reclamation;
use App\Models\Notification;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReclamationController extends Controller
{
    public function index()
    {
        $reclamations = Reclamation::all();
        return view('reclamations.index', compact('reclamations'));
    }

    public function create()
    {
        return view('reclamations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sujet' => 'required|string|max:255',
            'contenu' => 'required|string',
            'utilisateur_id' => 'required|exists:Utilisateur,id',
        ]);

        Reclamation::create($request->all());

        return redirect()->route('reclamations.index')
            ->with('success', 'Réclamation envoyée avec succès.');
    }

    public function reserver(Request $request, $annonce_id)
{
    $user_id = Auth::id();

    $request->validate([
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after:date_debut',
    ]);

    $reservation = Reservation::create([
        'client_id' => $user_id,
        'annonce_id' => $annonce_id,
        'date_debut' => $request->date_debut,
        'date_fin' => $request->date_fin,
        'statut' => 'en_attente'
    ]);

    Notification::create([
        'contenu' => 'Votre réservation a été enregistrée',
        'contenu_email' => 'Merci pour votre réservation sur MediaRent !',
        'sujet_email' => 'Confirmation de réservation',
        'utilisateur_id' => $user_id,
        'annonce_id' => $annonce_id,
        'date_creation' => now(),
        'envoyee' => false,
        'lue' => false
    ]);

    return redirect()->route('annonces.index') // redirige vers la page des annonces
        ->with('success', 'Réservation effectuée avec succès');
}



    
}

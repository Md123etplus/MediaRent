<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\NouvelleReservation;
use App\Mail\ReservationAccepted;
use App\Mail\ReservationRejected;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function create(Annonce $annonce)
    {
        $reservedPeriods = Reservation::where('annonce_id', $annonce->id)
            ->where(function($query) {
                $query->where('statut', 'confirmé')
                      ->orWhere('statut', 'en_attente');
            })
            ->select('date_debut', 'date_fin')
            ->get()
            ->toArray();
    
        return view('reservations.create', [
            'annonce' => $annonce,
            'reservedPeriods' => $reservedPeriods
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'annonce_id' => 'required|exists:annonce,id'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $annonce = Annonce::with(['proprietaire', 'objet'])->findOrFail($request->input('annonce_id'));
            
            $reservation = Reservation::create([
                'annonce_id' => $annonce->id,
                'client_id' => Auth::id(),
                'date_debut' => $request->input('date_debut'),
                'date_fin' => $request->input('date_fin'),
                'statut' => 'en_attente'
            ]);

            $this->sendReservationEmail($reservation, $annonce);

            return redirect()->route('reservations.formClient');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création de la réservation');
        }
    }

    public function storeDates(Request $request, Annonce $annonce)
    {
        $validator = Validator::make($request->all(), [
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $jours = $request->date_debut->diffInDays($request->date_fin);
            $prixTotal = $annonce->objet->prix_journalier * $jours;

            session([
                'reservation_data' => [
                    'annonce_id' => $annonce->id,
                    'date_debut' => $request->date_debut,
                    'date_fin' => $request->date_fin,
                    'prix_total' => $prixTotal
                ]
            ]);

            return redirect()->route('reservations.formClient');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du traitement des dates');
        }
    }

    public function respond(Request $request, $id, $response)
    {
        if (!in_array($response, ['accept', 'reject'])) {
            return back()->with('error', 'Action invalide');
        }
    
        try {
            $reservation = Reservation::with(['annonce.objet', 'annonce.proprietaire', 'client'])
                             ->findOrFail($id);
    
            $reservation->statut = ($response === 'accept') ? 'confirmée' : 'annulée';
            $reservation->save();
    
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
    
        } catch (\Exception $e) {
            logger()->error('Erreur envoi email acceptation: '.$e->getMessage());
            return back()->with('error', 'Erreur lors du traitement de la réponse');
        }
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


public function createStep2() // Afficher le formulaire de l'étape 2
{
    if (!Session::has('reservation_client_info') || !Session::has('reservation_annonce_id')) {
        // Rediriger vers l'étape 1 si les infos manquent
        return redirect()->route('annonces.index')->withErrors('Informations de réservation manquantes.');
    }
    $annonce = Annonce::findOrFail(Session::get('reservation_annonce_id'));
    // Vous pouvez passer $annonce à la vue pour afficher des détails
    return view('reservations.create_step2', compact('annonce'));
}


public function storeFullReservation(Request $request)
{
    $clientInfo = Session::get('reservation_client_info');
    $annonceId = Session::get('reservation_annonce_id');
    $reservationDates = Session::get('reservation_dates');

    if (!$clientInfo || !$annonceId || !$reservationDates) {
        return redirect()->route('annonces.index')->withErrors('Session de réservation expirée ou incomplète.');
    }

    $validatedData = $request->validate([
        'delivery_option' => 'required|in:pickup,delivery',
        'delivery_address' => 'nullable|required_if:delivery_option,delivery|string',
        'delivery_notes_client' => 'nullable|string',
    ]);

    // Gérer l'utilisateur :
    // 1. Si l'utilisateur est connecté: $user = Auth::user();
    // 2. Si ce flux est pour les invités qui doivent créer un compte / se connecter:
    $user = User::where('email', $clientInfo['email'])->first();
    if (!$user) {
        // Créer un nouvel utilisateur. Attention à la gestion du mot de passe, vérification email etc.
        // Ceci est une simplification. Une vraie inscription est plus complexe.
        $user = User::create([
            'nom' => $clientInfo['nom'],
            'prenom' => $clientInfo['prenom'],
            'email' => $clientInfo['email'],
            'CIN' => $clientInfo['CIN'],
            'mot_de_passe' => Hash::make(Str::random(10)), // MDP temporaire, l'utilisateur devrait le changer
            'role' => 'client', // ou la valeur par défaut
            // Les champs img_profil, img_cin_front, img_cin_back sont NOT NULL,
            // il faut prévoir une gestion (valeurs par défaut, placeholders, ou les rendre nullable)
            // Pour l'exemple, je vais supposer qu'ils peuvent être vides ou que vous avez une logique
             'img_profil' => 'placeholder.jpg', // A ajuster
             'img_cin_front' => 'placeholder.jpg', // A ajuster
             'img_cin_back' => 'placeholder.jpg', // A ajuster
        ]);
        // Potentiellement envoyer un email de bienvenue / vérification
    } else {
        // Vérifier si le CIN correspond, ou si d'autres infos de $clientInfo doivent mettre à jour $user
    }


    $annonce = Annonce::findOrFail($annonceId);

    $reservation = new Reservation();
    $reservation->client_id = $user->id;
    $reservation->annonce_id = $annonce->id;
    $reservation->date_debut = $reservationDates['date_debut'];
    $reservation->date_fin = $reservationDates['date_fin'];
    $reservation->delivery_option = $validatedData['delivery_option'];

    if ($validatedData['delivery_option'] === 'delivery') {
        $reservation->statut = 'pending_delivery_agreement'; // Statut initial pour accord livraison
        $reservation->delivery_address = $validatedData['delivery_address'];
        $reservation->delivery_notes_client = $validatedData['delivery_notes_client'] ?? null;
    } else {
        $reservation->statut = 'pending_confirmation'; // Ou 'confirmed' si aucune approbation partenaire n'est requise pour pickup
    }
    
    // $reservation->proprietaire_id = $annonce->proprietaire_id; // Pas dans la table reservation, mais utile à avoir via $annonce->proprietaire_id

    $reservation->save();

    // Nettoyer la session
    Session::forget(['reservation_client_info', 'reservation_annonce_id', 'reservation_dates']);

    // Envoyer notifications au client et au partenaire
    // Ex: Notification au partenaire si delivery_option == 'delivery' pour accord
    // Ex: Notification au client pour confirmer la réception de sa demande

    return redirect()->route('reservations.show', $reservation->id)->with('success', 'Votre demande de réservation a été soumise.');
}


    
}

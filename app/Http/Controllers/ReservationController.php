<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Annonce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\NouvelleReservation;
use App\Mail\ReservationAccepted;
use App\Mail\ReservationRejected;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create(Annonce $annonce)
{
    // Récupère toutes les dates réservées avec statut confirmé ou en attente
    $reservedPeriods = Reservation::where('annonce_id', $annonce->id)
        ->whereIn('statut', ['confirmée', 'en_attente'])
        ->get()
        ->map(function($reservation) {
            return [
                'from' => Carbon::parse($reservation->date_debut)->format('Y-m-d'),
                'to' => Carbon::parse($reservation->date_fin)->format('Y-m-d'),
                // Ajoutez ces champs pour le débogage
                'original_from' => $reservation->date_debut,
                'original_to' => $reservation->date_fin
            ];
        })
        ->toArray();

    // Ajoutez ce log pour vérification
    \Log::info('Reserved periods for annonce '.$annonce->id, $reservedPeriods);

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
        
        // Conversion des dates
        $dateDebut = Carbon::parse($request->date_debut)->startOfDay();
        $dateFin = Carbon::parse($request->date_fin)->startOfDay();
        
        // Calcul du nombre de jours et prix total
        $jours = $dateDebut->diffInDays($dateFin) + 1;
        $prixTotal = $annonce->objet->prix_journalier * $jours;

        // Création de la réservation
        $reservation = Reservation::create([
            'annonce_id' => $annonce->id,
            'client_id' => Auth::id(),
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'prix_total' => $prixTotal,
            'statut' => 'en_attente'
        ]);

        // Envoi des emails
        self::sendReservationEmail($reservation, $annonce);

        // Préparation des données pour la confirmation
        $reference = 'RES-'.time();
        
        return redirect()->route('reservations.confirmation', [
            'reference' => $reference,
            'annonce' => $annonce->id
        ])->with([
            'reservation' => [
                'date_debut' => $dateDebut->format('Y-m-d'),
                'date_fin' => $dateFin->format('Y-m-d'),
                'prix_total' => $prixTotal
            ]
        ]);

    } catch (\Exception $e) {
        return back()->with('error', 'Erreur lors de la création de la réservation: '.$e->getMessage());
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
            $dateDebut = $request->date_debut; 
            $dateFin = $request->date_fin;     
            
            $jours = Carbon::parse($dateDebut)->diffInDays(Carbon::parse($dateFin));
            $prixTotal = $annonce->objet->prix_journalier * $jours;
    
            session([
                'reservation_data' => [
                    'annonce_id' => $annonce->id,
                    'date_debut' => $dateDebut,
                    'date_fin' => $dateFin,
                    'prix_total' => $prixTotal,
                ]
            ]);
    
            return redirect()->route('reservations.payment', ['annonce' => $annonce->id]);
    
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

    public static function sendReservationEmail(Reservation $reservation, Annonce $annonce)
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

    public function createStep2()
    {
        if (!Session::has('reservation_client_info') || !Session::has('reservation_annonce_id')) {
            return redirect()->route('annonces.index')->withErrors('Informations de réservation manquantes.');
        }
        $annonce = Annonce::findOrFail(Session::get('reservation_annonce_id'));
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

        $user = User::where('email', $clientInfo['email'])->first();
        if (!$user) {
            $user = User::create([
                'nom' => $clientInfo['nom'],
                'prenom' => $clientInfo['prenom'],
                'email' => $clientInfo['email'],
                'CIN' => $clientInfo['CIN'],
                'mot_de_passe' => Hash::make(Str::random(10)),
                'role' => 'client',
                'img_profil' => 'placeholder.jpg',
                'img_cin_front' => 'placeholder.jpg',
                'img_cin_back' => 'placeholder.jpg',
            ]);
        }

        $annonce = Annonce::findOrFail($annonceId);

        $reservation = new Reservation();
        $reservation->client_id = $user->id;
        $reservation->annonce_id = $annonce->id;
        $reservation->date_debut = $reservationDates['date_debut'];
        $reservation->date_fin = $reservationDates['date_fin'];
        $reservation->delivery_option = $validatedData['delivery_option'];

        if ($validatedData['delivery_option'] === 'delivery') {
            $reservation->statut = 'pending_delivery_agreement';
            $reservation->delivery_address = $validatedData['delivery_address'];
            $reservation->delivery_notes_client = $validatedData['delivery_notes_client'] ?? null;
        } else {
            $reservation->statut = 'pending_confirmation';
        }

        $reservation->save();

        Session::forget(['reservation_client_info', 'reservation_annonce_id', 'reservation_dates']);

        return redirect()->route('reservations.show', $reservation->id)->with('success', 'Votre demande de réservation a été soumise.');
    }
}
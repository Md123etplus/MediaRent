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
        // Récupère toutes les dates réservées (confirmées ou en attente)
        $reservedPeriods = Reservation::where('annonce_id', $annonce->id)
            ->whereIn('statut', ['confirmée', 'en_attente'])
            ->get()
            ->map(function($reservation) {
                return [
                    'from' => Carbon::parse($reservation->date_debut)->format('Y-m-d'),
                    'to' => Carbon::parse($reservation->date_fin)->format('Y-m-d')
                ];
            })
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
        'annonce_id' => 'required|exists:annonce,id' // Fix: Changed 'annonce' to 'annonces' if your table is 'annonces'
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    try {
        $annonce = Annonce::where('id', $request->input('annonce_id'))
            ->with(['proprietaire', 'objet'])
            ->firstOrFail();

        // Calculate total price
        $jours = Carbon::parse($request->date_debut)->diffInDays(Carbon::parse($request->date_fin));
        $prixTotal = $annonce->objet->prix_journalier * $jours;

        // Create reservation
        $reservation = Reservation::create([
            'annonce_id' => $annonce->id,
            'client_id' => Auth::id(),
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
            'statut' => 'en_attente',
            'prix_total' => $prixTotal, // Store price in DB (optional)
        ]);

        // Generate a unique reference (e.g., MR-20240525-12345)
        $reference = 'MR-' . now()->format('Ymd') . '-' . rand(1000, 9999);

        // Store reservation data in session (for confirmation page)
        session(['reservation' => [
            'id' => $reservation->id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'prix_total' => $prixTotal,
            'reference' => $reference,
        ]]);

        // Send email (if needed)
        $this->sendReservationEmail($reservation, $annonce);

        // Redirect to confirmation page with reference & annonce ID/slug
        return redirect()->route('reservations.confirmation', [
            'reference' => $reference,
            'annonce' => $annonce->id, // or $annonce->slug if using slugs
        ]);

    } catch (\Exception $e) {
        return back()->with('error', 'Erreur lors de la création de la réservation: ' . $e->getMessage());
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
            // $dateDebut = $request->date_debut; 
            // $dateFin = $request->date_fin;     
            
            // $jours = Carbon::parse($dateDebut)->diffInDays(Carbon::parse($dateFin));
            $prixTotal = $annonce->objet->prix_journalier * $jours;
    
            session([
                'reservation_data' => [
                    'annonce_id' => $annonce->id,
                    'date_debut' => $request->date_debut,
                    'date_fin' => $request->date_fin,
                    'prix_total' => $prixTotal
                    // 'date_debut' => $dateDebut,
                    // 'date_fin' => $dateFin,
                    // 'prix_total' => $prixTotal,
                ]
            ]);
            // dd($request->all());

            return view('reservations.confirmation')->with('success', 'Compte créé avec succès !');

            // return redirect()->route('reservations.formClient');
    
            // return redirect()->route('reservations.payment', ['annonce' => $annonce->id]);
    
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
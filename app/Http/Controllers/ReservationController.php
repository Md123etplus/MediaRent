<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
}
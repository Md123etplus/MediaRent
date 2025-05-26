<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
// use App\Models\Plan;

class PaymentController extends Controller
{
    public function processPayment(Request $request, Annonce $annonce)
    {
        // 1. Vérification propriétaire
        if ($annonce->proprietaire_id !== Auth::id()) {
            Log::error('Accès non autorisé', [
                'user' => Auth::id(), 
                'annonce' => $annonce->id
            ]);
            abort(403);
        }
    
        // 2. Validation simple
        $request->validate([
            'plan_id' => 'required|in:1,2,3',
        ]);
    
        // 3. Durées des plans
        $durations = [1 => 7, 2 => 15, 3 => 30];
        $duration = $durations[$request->plan_id];
    
        // 4. Mise à jour DIRECTE en SQL
        $updated = DB::update("
            UPDATE annonce 
            SET premium = 1,
                date_debut = ?,
                date_fin = ?,
                statut = 'active',
                updated_at = NOW()
            WHERE id = ?
        ", [
            now()->format('Y-m-d'),
            now()->addDays($duration)->format('Y-m-d'),
            $annonce->id
        ]);
    
        // 5. Vérification
        if ($updated !== 1) {
            Log::critical('Échec mise à jour SQL', [
                'annonce_id' => $annonce->id,
                'rows_affected' => $updated
            ]);
            return back()->with('error', 'Échec technique');
        }
    
        // 6. Rechargement
        $annonce->refresh();
    
        return redirect()->route('annonces.payment-success', parameters: [
            'annonce' => $annonce->id, // Envoyez l'ID plutôt que l'objet complet
            'reference' => 'PAY-'.time() // Génère une référence unique
        ]);
    }
    
    protected function validatePaymentRequest(Request $request)
    {
        return $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'card_number' => 'required|string|regex:/^\d{16}$/',
            'expiry_date' => 'required|string|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required|string|digits:3',
            'card_holder' => 'required|string|max:255'
        ]);
    }
    protected function processPaymentTransaction($data, Annonce $annonce)
    {
        try {
            $plan = Plan::findOrFail($data['plan_id']);
            
            // Mise à jour avec les bonnes colonnes
            $annonce->update([
                'premium' => true, // Utilisez 'premium' au lieu de 'is_premium'
                'date_publication' => now(), // Réinitialise la date
                'statut' => 'active' // Assurez-vous que le statut est bien actif
            ]);
            
            Log::info('Paiement réussi', [
                'annonce_id' => $annonce->id,
                'plan' => $plan->name
            ]);
    
            return [
                'success' => true,
                'reference' => 'PAY-'.time()
            ];
        } catch (\Exception $e) {
            Log::error('Erreur payment', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Erreur technique'];
        }
    }

    public function showSuccess(Annonce $annonce, $reference)
    {
        // Charge toutes les relations nécessaires en une requête
        $annonce->load([
            'objet.categorie',
            'proprietaire',
            'reservations'
        ]);
    
        // Formatage des dates
        $dateFin = $annonce->date_fin->format('d/m/Y');
        $joursRestants = now()->diffInDays($annonce->date_fin);
    
        return view('annonces.payment_success', [
            'annonce' => $annonce,
            'reference' => $reference,
            'dateFin' => $dateFin,
            'joursRestants' => $joursRestants
        ]);
    }
    public function showPaymentForm(Annonce $annonce)
{
    // Vérifiez si l'utilisateur a une réservation en attente pour cette annonce
    $reservation = Reservation::where('annonce_id', $annonce->id)
                             ->where('client_id', Auth::id())
                             //->where('statut', 'en_attente')
                             ->first();

    if (!$reservation) {
        return redirect()->route('client.dashboard')
                       ->with('error', 'Aucune réservation en attente de paiement');
    }

    return view('annonces.payments.form', [
        'annonce' => $annonce,
        'reservation' => [
            'date_debut' => $reservation->date_debut,
            'date_fin' => $reservation->date_fin,
            'prix_total' => $reservation->date_debut->diffInDays($reservation->date_fin) * $annonce->objet->prix_journalier
        ]
    ]);
}
   public function validateReservationPaymentRequest(Request $request)
{
    return $request->validate([
        'card_number' => 'required|string|regex:/^\d{4}\s\d{4}\s\d{4}\s\d{4}$/',
        'expiry_date' => 'required|string|regex:/^\d{2}\/\d{2}$/',
        'cvv' => 'required|string|digits:3',
        'card_holder' => 'required|string|max:255'
    ]);
}
    public function processReservationPaymentTransaction( $paymentData, Annonce $annonce)
    {
        try {

            return [
                'success' => true,
                'reference' => 'RES-'.time()
            ];
        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement du paiement', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Erreur technique'];
        }
    }
    public function processReservationPayment(Request $request, Annonce $annonce)
{
    // dd($request->all());
    // Validation des données de paiement
    $this->validateReservationPaymentRequest($request);
// dd($request->all());
    // Traditement de la transaction
    $paymentResult = $this->processReservationPaymentTransaction($request->all(), $annonce);
    $reservation = Reservation::create([
                    'annonce_id' => $annonce->id,
                    'client_id' => Auth::id(),
                    'date_debut' => $request->input('date_debut'),
                    'date_fin' => $request->input('date_fin'),
                    'statut' => 'en_attente'
            ]);
   if ($paymentResult['success']) {
        ReservationController::sendReservationEmail($reservation, $annonce);

        $reservationData = session('reservation_data', []);
        
        return redirect()->route('reservations.confirmation', [
            'reference' => $paymentResult['reference'],
            'annonce' => $annonce // Pass the full object instead of just ID
        ])->with([
            'reservation' => $reservationData,
            'reference' => $paymentResult['reference']
        ]);
    }
    return back()->with('error', $paymentResult['message']);
}
}
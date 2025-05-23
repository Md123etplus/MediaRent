<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Evaluation;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;

class EvaluationController extends Controller
{
    public function show(Evaluation $evaluation)
    {
        // Vérifier que l'évaluation appartient bien à l'utilisateur connecté
        if ($evaluation->evaluateur_id !== Auth::id()) {
            abort(403);
        }

        // Charger les relations nécessaires
        $evaluation->load([
            'reservation.annonce.objet',
            'reservation.annonce.proprietaire'
        ]);

        // Passez un indicateur pour la vue
        return view('client.evaluations.show', [
            'evaluation' => $evaluation,
            'from_reservations' => request()->has('from_reservations')
        ]);
    }
    public function index()
    {
        //     $user = Auth::user();
        //     $evaluations = $user

        //     ? $user->evaluations()
        //     ->with(['reservation.annonce.objet.images', 'reservation.annonce.proprietaire'])
        //     ->orderBy('date', 'desc')
        //     ->paginate(10)
        // : new LengthAwarePaginator([], 0, 10);
        $testUser = User::find(Auth::id()); // Replace 123 with test user ID
        $evaluations = $testUser
        ? $testUser->evaluations()
            ->with([
                'reservation.annonce.objet.images', 
                'reservation.annonce.proprietaire'
            ])
            ->orderBy('date', 'desc')
            ->paginate(10)
        : new LengthAwarePaginator([], 0, 10);
                
            return view('client.evaluations.index', compact('evaluations'));
    }

    public function create(Reservation $reservation, $type)
    {
        // Vérifier que la réservation appartient bien à l'utilisateur connecté
        if ($reservation->client_id !== Auth::id() && $reservation->annonce->proprietaire->id !== Auth::id()) {
            return view('login.login');
        }
        
        if ($reservation->statut !== 'terminée') {
            return back()->with('error', 'Vous ne pouvez évaluer que les réservations terminées.');
        }
        
        return view('client.evaluations.create', [
            'reservation' => $reservation,
            'type' => $type
        ]);
    }


    public function store(Request $request, Reservation $reservation, string $type)
    {
        // Vérifier que l'utilisateur a le droit d'évaluer cette réservation
        if ($type === 'client_to_partner' && $reservation->client_id !== Auth::id()) {
            abort(403, 'Seul le client peut évaluer le partenaire');
        }

        if ($type === 'partner_to_client' && $reservation->annonce->proprietaire_id !== Auth::id()) {
            abort(403, 'Seul le partenaire peut évaluer le client');
        }

        // Validation des données selon le type d'évaluation
        if ($type === 'client_to_partner') {
            $validated = $request->validate([
                'note_partenaire' => 'required|integer|min:1|max:5',
                'commentaire_partenaire' => 'required|string|max:500',
                'note_objet' => 'required|integer|min:1|max:5',
                'commentaire_objet' => 'required|string|max:500',
            ]);
        } else {
            $validated = $request->validate([
                'note_client' => 'required|integer|min:1|max:5',
                'commentaire_client' => 'required|string|max:500',
            ]);
        }

        // Gestion des évaluations
        if ($type === 'client_to_partner') {
            // Mise à jour ou création de l'évaluation du partenaire
            Evaluation::updateOrCreate(
                [
                    'reservation_id' => $reservation->id,
                    'type' => 'client_to_partner'
                ],
                [
                    'objet_id' => $reservation->annonce->objet_id,
                    'evaluateur_id' => Auth::id(),
                    'evalue_id' => $reservation->annonce->proprietaire_id,
                    'note' => $validated['note_partenaire'],
                    'commentaire' => $validated['commentaire_partenaire'],
                    'date' => now()
                ]
            );

            // Création de l'évaluation de l'objet (toujours nouvelle)
            Evaluation::create([
                'reservation_id' => $reservation->id,
                'objet_id' => $reservation->annonce->objet_id,
                'evaluateur_id' => Auth::id(),
                'evalue_id' => $reservation->annonce->proprietaire_id,
                'note' => $validated['note_objet'],
                'commentaire' => $validated['commentaire_objet'],
                'date' => now(),
                'type' => 'objet_evaluation'
            ]);
        } else {
            // Mise à jour ou création de l'évaluation du client
            Evaluation::updateOrCreate(
                [
                    'reservation_id' => $reservation->id,
                    'type' => 'partner_to_client'
                ],
                [
                    'objet_id' => $reservation->annonce->objet_id,
                    'evaluateur_id' => Auth::id(),
                    'evalue_id' => $reservation->client_id,
                    'note' => $validated['note_client'],
                    'commentaire' => $validated['commentaire_client'],
                    'date' => now()
                ]
            );
        }

        // Vérifier si les deux évaluations sont complètes
        // $this->checkAndUpdateReservationStatus($reservation);

        if($type === 'client_to_partner')
            return redirect('/dashboard/client');
        else
            return redirect('/partenaire/dashboard'); //dashboard partenaire
    }

    protected function checkAndUpdateReservationStatus(Reservation $reservation)
    {
        $hasClientEvaluation = $reservation->evaluations()
            ->where('type', 'client_to_partner')
            ->whereNotNull('commentaire')
            ->exists();

        $hasPartnerEvaluation = $reservation->evaluations()
            ->where('type', 'partner_to_client')
            ->whereNotNull('commentaire')
            ->exists();

        if ($hasClientEvaluation && $hasPartnerEvaluation) {
            $reservation->update(['statut' => 'évaluée']);
        }
    }
    // public function edit(Evaluation $evaluation)
    // {
    //     // Vérifier que l'évaluation appartient bien à l'utilisateur connecté
    //     if ($evaluation->evaluateur_id !== Auth::id()) {
    //         abort(403);
    //     }
        
    //     // Vérifier que l'évaluation peut être modifiée (par exemple, dans un délai de 7 jours)
    //     if ($evaluation->date->diffInDays(Carbon::now()) > 7) {
    //         return back()->with('error', 'Vous ne pouvez plus modifier cette évaluation.');
    //     }
        
    //     return view('client.evaluations.edit', compact('evaluation'));
    // }

    public function update(Request $request, Evaluation $evaluation)
    {
        // Vérifier que l'évaluation appartient bien à l'utilisateur connecté
        if ($evaluation->evaluateur_id !== Auth::id()) {
            abort(403);
        }
        
        // Validation
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string|max:500',
        ]);
        
        // Mettre à jour l'évaluation
        $evaluation->update([
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);
        
        return redirect()->route('client.evaluations.index')
            ->with('success', 'Votre évaluation a été mise à jour avec succès.');
    }
}
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
class EvaluationController extends Controller
{
    public function index()
    {
    //     $user = Auth::user();
    //     $evaluations = $user

    //     ? $user->evaluations()
    //     ->with(['reservation.annonce.objet.images', 'reservation.annonce.proprietaire'])
    //     ->orderBy('date', 'desc')
    //     ->paginate(10)
    // : new LengthAwarePaginator([], 0, 10);
    $testUser = User::find(1); // Replace 123 with test user ID
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
    

    public function create(Reservation $reservation)
    {
        // Vérifier que la réservation appartient bien à l'utilisateur connecté
        if ($reservation->client_id !== Auth::id()) {
            abort(403);
        }
        
        // Vérifier que la réservation est terminée
        if ($reservation->statut !== 'terminée') {
            return back()->with('error', 'Vous ne pouvez évaluer que les réservations terminées.');
        }
        
        // Vérifier qu'il n'y a pas déjà une évaluation pour cette réservation
        if ($reservation->evaluation) {
            return back()->with('error', 'Cette réservation a déjà été évaluée.');
        }
        
        return view('client.evaluations.create', compact('reservation'));
    }
     




    public function store(Request $request, Reservation $reservation)
    {
        // Vérifier que la réservation appartient bien à l'utilisateur connecté
        if ($reservation->client_id !== Auth::id()) {
            abort(403);
        }
        
        // Validation
        $request->validate([
            'note_objet' => 'required|integer|min:1|max:5',
            'note_proprietaire' => 'required|integer|min:1|max:5',
            'commentaire_objet' => 'required|string|max:500',
            'commentaire_proprietaire' => 'required|string|max:500',
        ]);
        
        // Créer l'évaluation
        Evaluation::create([
            'objet_id' => $reservation->annonce->objet_id,
            'evaluateur_id' => Auth::id(),
            'evalue_id' => $reservation->annonce->proprietaire_id,
            'note_objet' => $request->note_objet,
            'note_proprietaire' => $request->note_proprietaire,
            'commentaire_objet' => $request->commentaire_objet,
            'commentaire_proprietaire' => $request->commentaire_proprietaire,
            'date' => Carbon::now(),
            'reservation_id' => $reservation->id,
        ]);
        
        return redirect()->route('client.evaluations.index')
            ->with('success', 'Votre évaluation a été enregistrée avec succès.');
    }

    public function show(Evaluation $evaluation)
    {
        // Vérifier que l'évaluation appartient bien à l'utilisateur connecté
        if ($evaluation->evaluateur_id !== Auth::id()) {
            abort(403);
        }
        
        return view('client.evaluations.show', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation)
    {
        // Vérifier que l'évaluation appartient bien à l'utilisateur connecté
        if ($evaluation->evaluateur_id !== Auth::id()) {
            abort(403);
        }
        
        // Vérifier que l'évaluation peut être modifiée (par exemple, dans un délai de 7 jours)
        if ($evaluation->date->diffInDays(Carbon::now()) > 7) {
            return back()->with('error', 'Vous ne pouvez plus modifier cette évaluation.');
        }
        
        return view('client.evaluations.edit', compact('evaluation'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        // Vérifier que l'évaluation appartient bien à l'utilisateur connecté
        if ($evaluation->evaluateur_id !== Auth::id()) {
            abort(403);
        }
        
        // Validation
        $request->validate([
            'note_objet' => 'required|integer|min:1|max:5',
            'note_proprietaire' => 'required|integer|min:1|max:5',
            'commentaire_objet' => 'required|string|max:500',
            'commentaire_proprietaire' => 'required|string|max:500',
        ]);
        
        // Mettre à jour l'évaluation
        $evaluation->update([
            'note_objet' => $request->note_objet,
            'note_proprietaire' => $request->note_proprietaire,
            'commentaire_objet' => $request->commentaire_objet,
            'commentaire_proprietaire' => $request->commentaire_proprietaire,
        ]);
        
        return redirect()->route('client.evaluations.index')
            ->with('success', 'Votre évaluation a été mise à jour avec succès.');
    }
}
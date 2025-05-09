<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function index()
{
    $evaluations = Evaluation::with([
        'reservation.annonce.objet.images', 
        'reservation.annonce.proprietaire'
    ])->where('evaluateur_id', Auth::id())->get();

    return view('client.evaluations.index', compact('evaluations'));
}

    public function store(Request $request)
    {
    $validated = $request->validate([
        'reservation_id' => 'required|exists:reservations,id',
        'note_objet' => 'required|integer|between:1,5',
        'note_proprietaire' => 'required|integer|between:1,5',
        'commentaire_objet' => 'nullable|string|max:500',
        'commentaire_proprietaire' => 'nullable|string|max:500',
    ]);

    $reservation = Reservation::with(['annonce.objet', 'annonce.proprietaire'])
        ->findOrFail($request['reservation_id']);

    // Debug crucial
    Log::info("Creating evaluation for reservation:", [
        'expected_id' => $reservation->id,
        'actual_data' => $reservation->toArray()
    ]);

        // Vérifier si une évaluation existe déjà
        $existingEvaluation = Evaluation::where('reservation_id', $reservation->id)->first();
        
        if ($existingEvaluation) {
            return response()->json(['error' => 'Une évaluation existe déjà pour cette réservation'], 422);
        }

        $evaluation = $reservation->evaluation()->create([
            'reservation_id' => $reservation->id,
            'objet_id' => $reservation->annonce->objet->id,
            'evaluateur_id' => Auth::id(),
            'evalue_id' => $reservation->annonce->proprietaire->id,
            'note_objet' => $validated['note_objet'],
            'note_proprietaire' => $validated['note_proprietaire'],
            'commentaire_objet' => $validated['commentaire_objet'],
            'commentaire_proprietaire' => $validated['commentaire_proprietaire'],
            'date' => now(),
        ]);

        return response()->json([
            'success' => true,
            'evaluation' => $evaluation,
            'message' => 'Évaluation soumise avec succès'
        ]);
    }

    public function showByReservation($reservationId)
    {
        $evaluation = Evaluation::where('reservation_id', $reservationId)->firstOrFail();
        return response()->json($evaluation);
    }
}
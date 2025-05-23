<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Reservation;
use Illuminate\Contracts\Encryption\DecryptException;
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

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'reservation_id' => 'required|exists:reservations,id',
    //         'note' => 'required|integer|between:1,5',
    //         'commentaire' => 'nullable|string|max:500',
    //     ]);

    //     $reservation = Reservation::with(['annonce.objet', 'annonce.proprietaire'])
    //         ->findOrFail($request['reservation_id']);

    //     // Debug crucial
    //     Log::info("Creating evaluation for reservation:", [
    //         'expected_id' => $reservation->id,
    //         'actual_data' => $reservation->toArray()
    //     ]);

    //     // Vérifier si une évaluation existe déjà
    //     $existingEvaluation = Evaluation::where('reservation_id', $reservation->id)->first();
        
    //     if ($existingEvaluation) {
    //         return response()->json(['error' => 'Une évaluation existe déjà pour cette réservation'], 422);
    //     }

    //     $evaluation = $reservation->evaluation()->create([
    //         'reservation_id' => $reservation->id,
    //         'objet_id' => $reservation->annonce->objet->id,
    //         'evaluateur_id' => Auth::id(),
    //         'evalue_id' => $reservation->annonce->proprietaire->id,
    //         'note' => $validated['note'],
    //         'commentaire' => $validated['commentaire'],
    //         'date' => now(),
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'evaluation' => $evaluation,
    //         'message' => 'Évaluation soumise avec succès'
    //     ]);
    // }

    public function showByReservation($reservationId)
    {
        $evaluation = Evaluation::where('reservation_id', $reservationId)->firstOrFail();
        return response()->json($evaluation);
    }

    public function create(Request $request, Reservation $reservation, $type)
    {
        // Vérification du token
        try {
            [$reservationId, $evalType] = explode(':', decrypt($request->token));
            if ($reservation->id != $reservationId || $type != $evalType) {
                abort(403);
            }
        } catch (DecryptException $e) {
            abort(403);
        }

        return view('evaluations.create', [
            'reservation' => $reservation,
            'type' => $type
        ]);
    }

    public function store(Request $request, Reservation $reservation, $type)
    {
        $validated = $request->validate([
            'note' => 'required|integer|between:1,5',
            'commentaire' => 'required|string|max:500'
        ]);

        $evaluation = Evaluation::where('reservation_id', $reservation->id)
            ->where('type', $type)
            ->firstOrFail();

        $evaluation->update($validated);

        // Vérifier si les deux évaluations sont complètes
        $this->checkCompleteEvaluations($reservation);

        return redirect()->route('thank-you');
    }

    protected function checkCompleteEvaluations(Reservation $reservation)
    {
        $incomplete = Evaluation::where('reservation_id', $reservation->id)
            ->whereNull('commentaire')
            ->exists();

        if (!$incomplete) {
            Evaluation::where('reservation_id', $reservation->id)
                ->update(['is_public' => true]);
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::all();
        return view('client.evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        return view('evaluations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
            'evaluateur_id' => 'required|exists:Utilisateur,id',
            'evalue_id' => 'required|exists:Utilisateur,id',
        ]);

        Evaluation::create($request->all());

        return redirect()->route('evaluations.index')
            ->with('success', 'Évaluation ajoutée avec succès.');
    }
}

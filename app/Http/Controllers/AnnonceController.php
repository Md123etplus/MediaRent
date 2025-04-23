<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Objet;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function create()
    {
        $categories = Categorie::all();
        $objets = Objet::where('proprietaire_id', Auth::id())->get();
        
        return view('annonces.create', compact('categories', 'objets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'objet_id' => 'required|exists:Objet,id',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'adresse' => 'required|string|max:255',
            'premium' => 'sometimes|boolean',
            'description' => 'required|string'
        ]);

        // Vérifier que l'objet appartient bien à l'utilisateur
        $objet = Objet::findOrFail($validated['objet_id']);
        if ($objet->proprietaire_id !== Auth::id()) {
            abort(403, "Vous n'êtes pas propriétaire de cet objet");
        }

        $annonce = Annonce::create([
            'proprietaire_id' => Auth::id(),
            'objet_id' => $validated['objet_id'],
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'],
            'adress' => $validated['adresse'],
            'premium' => $request->has('premium'),
            'statut' => 'active',
            'date_publication' => now(),
            'description' => $validated['description']
        ]);

        return redirect()->route('partenaire.dashboard')
               ->with('success', 'Annonce créée avec succès');
    }

    public function index()
    {
        $annonces = Annonce::where('proprietaire_id', auth()->id())->get();
        return view('partenaire.annonces.index', compact('annonces'));
    }
    
   
}
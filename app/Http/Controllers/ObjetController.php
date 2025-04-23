<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objet;
use App\Models\Categorie;

class ObjetController extends Controller
{
    // Affiche tous les objets
    public function index()
    {
        $objets = Objet::with('categorie')->get();
        return view('objets.index', compact('objets'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        $categories = Categorie::all();
        return view('objets.create', compact('categories'));
    }

    // Enregistre un nouvel objet
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ville' => 'required|string|max:100',
            'proprietaire_id' => 'required|exists:Utilisateur,id',
            'categorie_id' => 'required|exists:Categorie,id',
            'prix_journalier' => 'required|numeric',
            'etat' => 'required|string'
        ]);

        Objet::create($request->all());

        return redirect()->route('objets.index')
            ->with('success', 'Objet créé avec succès.');
    }

    // Affiche un objet
    public function show($id)
    {
        $objet = Objet::with('categorie')->findOrFail($id);
        return view('objets.show', compact('objet'));
    }

    // Formulaire de modification
    public function edit($id)
    {
        $objet = Objet::findOrFail($id);
        $categories = Categorie::all();
        return view('objets.edit', compact('objet', 'categories'));
    }

    // Mise à jour d’un objet
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ville' => 'required|string|max:100',
            'proprietaire_id' => 'required|exists:Utilisateur,id',
            'categorie_id' => 'required|exists:Categorie,id',
            'prix_journalier' => 'required|numeric',
            'etat' => 'required|string'
        ]);

        $objet = Objet::findOrFail($id);
        $objet->update($request->all());

        return redirect()->route('objets.index')
            ->with('success', 'Objet mis à jour avec succès.');
    }

    // Suppression
    public function destroy($id)
    {
        $objet = Objet::findOrFail($id);
        $objet->delete();

        return redirect()->route('objets.index')
            ->with('success', 'Objet supprimé avec succès.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Objet;
use App\Models\Categorie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use App\Models\Objet;
// use App\Models\Utilisateur;
use App\Models\User;
// use App\Models\Categorie;
class ObjetController extends Controller
{
    public function create()
    {
        $categories = Categorie::all();
        return view('objet.create', compact('categories'));
    }

    public function store(Request $request)
{
    // Validation (inchangé)
    $request->validate([
        'nom' => 'required|string',
        'description' => 'required|string',
        'ville' => 'required|string',
        'prix_journalier' => 'required|numeric',
        'categorie_id' => 'required|integer|exists:categorie,id',
        'etat' => 'required|string|in:dispo,indispo',
        'images' => 'required|array|min:1|max:3',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Création de l'objet (inchangé)
    $objet = new Objet();
    $objet->nom = $request->nom;
    $objet->description = $request->description;
    $objet->ville = $request->ville;
    $objet->prix_journalier = $request->prix_journalier;
    $objet->categorie_id = $request->categorie_id;
    $objet->etat = $request->etat;
    $objet->proprietaire_id = 1; // ou Auth::id()
    $objet->save();

    // Enregistrement des images modifié
    foreach ($request->file('images') as $file) {
        $filename = 'objet_' . $objet->id . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);

        $image = new Image();
        $image->objet_id = $objet->id;
        $image->url = 'images/' . $filename; // Supprimez 'public/' ici
        $image->save();
    }

    return redirect()->route('objet.create')->with('success', 'Objet créé avec succès !');
}
    public function index()
    {
        $objets = Objet::where('proprietaire_id', Auth::id())->get();
        return view('objets.index', compact('objets'));
    }



    ////////////////////////
    public function show($id)
    {
        $objet = Objet::with('categorie')->findOrFail($id);
        return view('objets.show', compact('objet'));
    }
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

public function mesObjets()
{
    $objets = Objet::with(['images', 'categorie'])
                ->where('proprietaire_id', 1)
                ->latest()
                ->get();

    return view('objet.mes_objets', compact('objets'));
}
}

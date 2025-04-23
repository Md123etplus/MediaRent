<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objet;
use App\Models\Categorie;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ObjetController extends Controller
{
    public function create()
    {
        $categories = Categorie::all();
        return view('objet.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validation de l'objet
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

        // Création de l'objet
        $objet = new Objet();
        $objet->nom = $request->nom;
        $objet->description = $request->description;
        $objet->ville = $request->ville;
        $objet->prix_journalier = $request->prix_journalier;
        $objet->categorie_id = $request->categorie_id;
        $objet->etat = $request->etat;
        $objet->proprietaire_id = 1; // ou Auth::id() si tu veux l'utilisateur connecté
        $objet->save();

        // Enregistrement des images
        foreach ($request->file('images') as $file) {
            $filename = 'objet_' . $objet->id . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            $image = new Image();
            $image->objet_id = $objet->id;
            $image->url = 'images/' . $filename;
            $image->save();
        }

        return redirect()->route('objet.create')->with('success', 'Objet créé avec succès !');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Objet;
use App\Models\Categorie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


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
        'etat' => 'required|string|in:neuf,bon,usé',
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
    $objet->proprietaire_id = Auth::id(); // ou Auth::id()
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
    $objet = Objet::where('proprietaire_id', auth()->id())
                ->findOrFail($id);
    $categories = Categorie::all();
    
    return view('objet.edit', compact('objet', 'categories'));
}

public function update(Request $request, $id)
{
    $objet = Objet::where('proprietaire_id', auth()->id())
                ->findOrFail($id);

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'ville' => 'required|string|max:255',
        'categorie_id' => 'required|exists:categorie,id',
        'prix_journalier' => 'required|numeric|min:0',
        'etat' => 'required|string|in:neuf,bon,usé',
        'images' => 'sometimes|array|max:3',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Mise à jour des champs de base
    $objet->update($validated);

    // Gestion des images
    if ($request->hasFile('images')) {
        // Supprimer les anciennes images si nécessaire
        foreach ($objet->images as $image) {
            $imagePath = public_path($image->url);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();
        }

        // Ajouter les nouvelles images
        foreach ($request->file('images') as $file) {
            $filename = 'objet_'.$objet->id.'_'.time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            $objet->images()->create([
                'url' => 'images/'.$filename
            ]);
        }
    }

    return redirect()->route('objet.mes_objets')->with('success', 'Objet mis à jour avec succès');
}

public function toggleStatut($id)
{
    $objet = Objet::where('proprietaire_id', auth()->id())
                ->findOrFail($id);
                
    $objet->update([
        'statut' => $objet->statut === 'active' ? 'archived' : 'active'
    ]);

    return back()->with('success', 'Statut de l\'objet mis à jour');
}

public function mesObjets()
{
    $objets = Objet::with(['images', 'categorie'])
                ->where('proprietaire_id', auth()->id())
                ->latest()
                ->get();

    return view('objet.mes_objets', compact('objets'));
}
}

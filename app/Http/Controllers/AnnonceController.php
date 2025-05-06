<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Objet;
// use App\Models\Image;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorie;
class AnnonceController extends Controller{
    public function create()
    {
        $categories = Categorie::all();
        $objets = Objet::where('proprietaire_id', Auth::id())->get();
        
        return view('annonces.create', compact('categories', 'objets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'objet_id' => 'required|exists:objet,id',
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
    // Récupérer les annonces premium en premier, puis les autres
    $annonces = Annonce::with(['objet.images', 'proprietaire'])
        ->orderBy('premium', 'desc') // Les annonces premium (premium=1) seront en premier
        ->orderBy('date_publication', 'desc') // Ensuite tri par date de publication
        ->get();

    return view('annonces.index', compact('annonces'));
}



    public function show(Annonce $annonce)
{
    $annonce->load([
        'objet.images',
        'objet.categorie',
        'proprietaire'
    ]);
    $annonce->load(['objet.images', 'proprietaire']);
    return view('annonces.show', compact('annonce'));


}


public function mesAnnonces()
{
    $annonces = Annonce::where('proprietaire_id', 1)
    ->whereIn('statut', ['active', 'archivée']) // Affiche les deux statuts
    ->orderBy('created_at', 'desc')
    ->get();
    return view('annonces.mes_annonces', compact('annonces'));
}


public function archiver($id)
    {
        $annonce = Annonce::findOrFail($id);

        // Vérifie que l'utilisateur est bien le propriétaire
        if ($annonce->proprietaire_id != Auth::id()) {
            abort(403);
        }

        $annonce->statut = 'archivée';
        $annonce->save();

        return redirect()->back()->with('success', 'Annonce archivée avec succès.');
    }

    // Afficher le formulaire de choix du forfait
public function showPremiumForm(Annonce $annonce)
{
    if ($annonce->proprietaire_id !== auth()->id()) {
        abort(403, "Vous n'êtes pas propriétaire de cette annonce.");
    }

    // Forfaits codés en dur (simulation)
    $plans = [
        ['id' => 1, 'name' => '7 jours', 'duration_days' => 7, 'price' => 9.99],
        ['id' => 2, 'name' => '15 jours', 'duration_days' => 15, 'price' => 14.99],
        ['id' => 3, 'name' => '1 mois', 'duration_days' => 30, 'price' => 19.99],
    ];

    return view('annonces.premium', compact('annonce', 'plans')); 
}


// Afficher la confirmation
public function paymentSuccess(Annonce $annonce)
{
    return view('annonces.payment_success', compact('annonce')); }
}

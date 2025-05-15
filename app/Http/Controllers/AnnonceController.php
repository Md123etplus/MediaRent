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
        // Récupère uniquement les objets de l'utilisateur connecté
        $objets = Objet::where('proprietaire_id', Auth::id())->get();
        
        return view('annonces.create', compact('objets'));
    }

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'adress' => 'required|string|max:255',
            'objet_id' => 'required|exists:objet,id',
            'statut' => 'required|in:active,inactive',
            'premium' => 'sometimes|boolean'
        ]);
    
        // Vérification seulement si l'annonce est active
        if ($request->statut == 'active') {
            $annoncesActives = Annonce::where('proprietaire_id', Auth::id())
                                    ->where('statut', 'active')
                                    ->count();
    
            if ($annoncesActives >= 5) {
                return back()->withInput()->withErrors([
                    'limit' => 'Vous avez atteint la limite de 5 annonces actives. 
                               Vous pouvez créer cette annonce comme "inactive" ou archiver une annonce existante.'
                ]);
            }
        }
    
        // Création de l'annonce
        $annonce = new Annonce();
        $annonce->fill($validated);
        $annonce->proprietaire_id = Auth::id();
        $annonce->date_publication = now();
        $annonce->save();
    
        return redirect()->route('annonces.mes_annonces')->with('success', 'Annonce créée avec succès');
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
    $annonces = Annonce::where('proprietaire_id', Auth::id())
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

    public function restore($id)
    {
        // Vérifier le nombre d'annonces actives
        $activeAnnonces = Annonce::where('proprietaire_id', Auth::id())
                               ->where('statut', 'active')
                               ->count();
    
        if ($activeAnnonces >= 5) {
            return redirect()->back()
                   ->with('error', 'Vous avez déjà 5 annonces actives. Vous ne pouvez pas en restaurer plus.');
        }
    
        $annonce = Annonce::findOrFail($id);
        $annonce->update(['statut' => 'active']);
    
        return redirect()->back()
               ->with('success', 'Annonce restaurée avec succès');
    }

    

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string',
            'ville' => 'nullable|string',
            'categorie' => 'nullable|string', // Changé pour utiliser le nom de la catégorie comme dans la vue
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'min_rating' => 'nullable|integer|min:1|max:5',
            'prix_min' => 'nullable|numeric|min:0',
            'prix_max' => 'nullable|numeric|min:0',
        ]);
        
        $annonces = Annonce::with(['objet.images', 'proprietaire', 'objet.evaluations', 'objet.categorie'])
            ->when($request->filled('q'), function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->whereHas('objet', function($q) use ($request) {
                        $q->where('nom', 'like', "%{$request->q}%")
                          ->orWhere('description', 'like', "%{$request->q}%");
                    })
                    ->orWhere('adress', 'like', "%{$request->q}%");
                });
            })
            ->when($request->filled('ville'), function($query) use ($request) {
                $query->where('adress', 'like', "%{$request->ville}%");
            })
            ->when($request->filled('categorie'), function($query) use ($request) {
                $query->whereHas('objet.categorie', function($q) use ($request) {
                    $q->where('nom', $request->categorie); // Modification pour correspondre exactement
                });
            })
            ->when($request->filled('date_debut') && $request->filled('date_fin'), function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('date_debut', '<=', $request->date_fin)
                      ->where('date_fin', '>=', $request->date_debut);
                });
            })
            ->when($request->filled('min_rating'), function($query) use ($request) {
                $query->whereHas('objet.evaluations', function($q) use ($request) {
                    $q->select('objet_id')
                      ->groupBy('objet_id')
                      ->havingRaw('AVG(note_objet) >= ?', [$request->min_rating]);
                });
            })
            ->when($request->filled('prix_min'), function($query) use ($request) {
                $query->whereHas('objet', function($q) use ($request) {
                    $q->where('prix_journalier', '>=', $request->prix_min);
                });
            })
            ->when($request->filled('prix_max'), function($query) use ($request) {
                $query->whereHas('objet', function($q) use ($request) {
                    $q->where('prix_journalier', '<=', $request->prix_max);
                });
            })
            ->where('statut', 'active')
            ->orderBy('premium', 'desc')
            ->orderBy('date_publication', 'desc')
            ->paginate(10);
            
        $categories = Categorie::all();
        
        return view('annonces.search-results', [
            'annonces' => $annonces,
            'categories' => $categories,
            'searchTerm' => $request->q ?? '',
            'searchParams' => $request->all()
        ]);
    }
    // Afficher le formulaire de choix du forfait
public function showPremiumForm(Annonce $annonce)
{
    if ($annonce->proprietaire_id !== Auth::id()) {
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



    public function map()
    {
        $annonces = Annonce::with(['objet.images', 'objet.categorie'])
                    ->whereHas('objet', function($query) {
                        $query->whereNotNull('latitude')
                              ->whereNotNull('longitude');
                    })
                    ->where('statut', 'active')  // Only show active listings
                    ->get();
    
        // Use a consistent view name
        return view('client.annonces.map', compact('annonces'));
    }
    

    public function edit(Annonce $annonce)
    {
    $objets = Objet::all(); // Ou Objet::where(...) selon vos besoins
    return view('annonces.edit', compact('annonce', 'objets'));
    }

    public function update(Request $request, Annonce $annonce)
{
    // Validation des données
    $validatedData = $request->validate([
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after:date_debut',
        'adress' => 'required|string|max:255',
        'objet_id' => 'required|exists:objet,id', // Notez 'objet' au singulier
        'statut' => 'required|in:active,inactive', // Correction du nom du champ
        'premium' => 'sometimes|boolean'
    ]);

    // Vérification des autorisations
    if ($annonce->proprietaire_id !== Auth::id()) {
        abort(403, 'Action non autorisée');
    }

    // Conversion de la valeur checkbox
    $validatedData['premium'] = $request->has('premium');

    // Mise à jour de l'annonce
    $annonce->update($validatedData);

    // Redirection vers la route 'annonces.index' (mes-annonces)
    return redirect()->back()->with('success', 'Annonce modifier avec succès.');
}

}

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
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'adress' => 'required|string',
            'objet_id' => 'nullable|exists:objet,id',
            'date_publication' => 'required|date',
            'statut' => 'required|in:active,inactive',
            'proprietaire_id' => 'required|exists:users,id',
            'premium' => 'nullable|boolean',
            
        ]);

        // Vérifier que l'objet appartient bien à l'utilisateur
        $objet = Objet::findOrFail($validated['objet_id']);
        if ($objet->proprietaire_id !== Auth::id()) {
            abort(403, "Vous n'êtes pas propriétaire de cet objet");
        }
        
        $validated['date_publication'] = now();
        $validated['premium'] = $request->has('premium');
        $validated['proprietaire_id'] = Auth::id(); // utilisateur connecté
        Annonce::create($validated);

        return redirect()->route('annonces.create')->with('success', 'Annonce ajoutée !');

        // return redirect()->route('partenaire.dashboard')
        //        ->with('success', 'Annonce créée avec succès');
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
                      ->havingRaw('AVG(note) >= ?', [$request->min_rating]);
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
}

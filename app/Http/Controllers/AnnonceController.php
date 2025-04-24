<?php
// filepath: c:\Users\HP\Desktop\MediaRent\app\Http\Controllers\AnnonceController.php
namespace App\Http\Controllers;
use App\Models\Annonce;
use App\Models\Objet;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class AnnonceController extends Controller{
    public function create()
    {
        // Récupérer les objets depuis la base de données
        $objets = Objet::all();

        // Retourner la vue avec les objets
        return view('annonces.create', compact('objets'));
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


    $validated['date_publication'] = now();
    $validated['premium'] = $request->has('premium');
    // $validated['proprietaire_id'] = auth()->id(); // utilisateur connecté
    $validated['proprietaire_id'] =1;

    Annonce::create($validated);

    return redirect()->route('annonces.create')->with('success', 'Annonce ajoutée !');
    Log::info('Méthode store appelée');
    dd($request->all()); // Vérifie les données reçues
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
        $annonces = Annonce::where('proprietaire_id', 1)->get();

        $annonce->statut = 'archivée';
        $annonce->save();

        return redirect()->back()->with('success', 'Annonce archivée avec succès.');
    }

    public function restore($id)
    {
        $annonce = Annonce::findOrFail($id);

        // Vérifie que l'utilisateur est bien le propriétaire
        $annonces = Annonce::where('proprietaire_id', 1)->get();

        $annonce->statut = 'active';
        $annonce->save();

        return redirect()->back()->with('success', 'Annonce restaurer avec succès.');
    }



public function Annonces()
{
    $annonces = Annonce::where('proprietaire_id', 1)->get();
    return view('annonces.annonces', compact('annonces'));
}




}
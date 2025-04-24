<?php
// filepath: c:\Users\HP\Desktop\MediaRent\app\Http\Controllers\AnnonceController.php
namespace App\Http\Controllers;
use App\Models\Annonce;
use App\Models\Objet;
// use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
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
        // Récupérer les annonces depuis la base de données
        $annonces = Annonce::with(['objet.images', 'proprietaire'])->get();

        // Retourner la vue avec les annonces
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
       // TEMPORAIRE pour tests : afficher les annonces d’un user spécifique
$annonces = Annonce::where('proprietaire_id', 1)->get();

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
        $annonces = Annonce::query();

        if ($request->filled('ville')) {
            $annonces->where('ville', 'LIKE', '%' . $request->ville . '%');
        }

        if ($request->filled('type')) {
            $annonces->where('type', $request->type);
        }

        if ($request->filled('prix_max')) {
            $annonces->where('prix', '<=', $request->prix_max);
        }

        if ($request->filled('note_min')) {
            $annonces->where('note', '>=', $request->note_min);
        }

        $resultats = $annonces->get();

        return view('annonces.resultats', compact('resultats'));
    }
    

}
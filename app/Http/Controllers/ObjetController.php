<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Objet;
use App\Models\Categorie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\GeocoderService;
// use App\Models\Objet;
// use App\Models\Utilisateur;
use App\Models\User;
// use App\Models\Categorie;
use App\Models\Annonce;
class ObjetController extends Controller
{
    public function create()
    {
        $categories = Categorie::all();
        return view('objet.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'ville' => 'required|string|min:3',
            'prix_journalier' => 'required|numeric|min:0',
            'categorie_id' => 'required|integer|exists:categorie,id',
            'etat' => 'required|in:neuf,bon,usé,dispo,indispo',
            'images' => 'required|array|min:1|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        // Appel au géocodeur
        try {
            $geodata = GeocoderService::getCoordinates($validated['ville']);
            $latitude = $geodata['lat'];
            $longitude = $geodata['lng'];
        } catch (\Exception $e) {
            // Optionnel : Log erreur
            $latitude = null;
            $longitude = null;
        }
    
        // Création de l’objet
        $objet = new Objet();
        $objet->nom = $validated['nom'];
        $objet->description = $validated['description'];
        $objet->ville = $validated['ville'];
        $objet->prix_journalier = $validated['prix_journalier'];
        $objet->categorie_id = $validated['categorie_id'];
        $objet->etat = $validated['etat'];
        $objet->proprietaire_id = Auth::id();
        $objet->latitude = $latitude;
        $objet->longitude = $longitude;
        $objet->save();
    
        // Enregistrement des images
        foreach ($request->file('images') as $file) {
            $filename = 'objet_' . $objet->id . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
    
            Image::create([
                'objet_id' => $objet->id,
                'url' => 'images/' . $filename
            ]);
        }
    
        return redirect()->route('objet.create')->with('success', 'Objet créé avec succès avec géolocalisation.');
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
    public function edit(Objet $objet)
{
    // Vérifie que l'utilisateur est bien le propriétaire
    if ($objet->proprietaire_id !==Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $categories = Categorie::all(); // Si vous avez des catégories
    return view('objet.edit', compact('objet', 'categories'));
}

    // Mise à jour d’un objet
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'ville' => 'required|string|min:3',
            'prix_journalier' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categorie,id',
            'etat' => 'required|in:dispo,indispo'
        ]);

        $objet = Objet::findOrFail($id);

        // Si la ville a changé, mettre à jour les coordonnées
        if ($objet->ville !== $validated['ville']) {
            $geodata = GeocoderService::getCoordinates($validated['ville']);
            $validated['latitude'] = $geodata['lat'];
            $validated['longitude'] = $geodata['lng'];
        }

        $objet->update($validated);

        return redirect()->route('mes.objets')
            ->with('success', 'Objet mis à jour avec succès.');
    }

    public function destroy(Objet $objet)
    {
        // Vérification du propriétaire
        if ($objet->proprietaire_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        // Supprimez les images associées si nécessaire
        // foreach ($objet->images as $image) {
        //     Storage::delete($image->url);
        //     $image->delete();
        // }
    
        $objet->delete();
    
        return redirect()->route('mes.objets')->with('success', 'Objet supprimé avec succès');
    }

    public function mesObjets()
    {
        // Vérifie d'abord si l'utilisateur est authentifié
        if (Auth::check()) {
            $objets = Objet::with(['images', 'categorie'])
                        ->where('proprietaire_id', Auth::id()) // Utilise l'ID de l'utilisateur connecté
                        ->latest()
                        ->get();
    
            return view('objet.mes_objets', compact('objets'));
        }
    
        // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir vos objets.');
    }
public function listeAnnonces()
{
    $annonces = Annonce::with([
            'objet.images', 
            'objet.categorie',
            'objet.evaluations'
        ])
        ->has('objet') // Garantit que seules les annonces avec objet sont chargées
        ->where('statut', 'active')
        ->orderBy('premium', 'desc')
        ->orderBy('date_publication', 'desc')
        ->get();

    return view('annonces.index', compact('annonces'));
}

}



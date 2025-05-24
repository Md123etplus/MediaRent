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
use Illuminate\Support\Facades\DB;
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

    public function edit($id)
    {
        $objet = Objet::where('proprietaire_id', Auth::id())
            ->findOrFail($id);
        $categories = Categorie::all();

        return view('objet.edit', compact('objet', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $objet = Objet::where('proprietaire_id', Auth::id())
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
            'keep_images' => 'sometimes|array',
            'keep_images.*' => 'exists:image,id',
        ]);

        // Mise à jour des champs de base
        $objet->update($request->except(['images', 'keep_images']));

        // Gestion des images existantes
        if ($request->has('keep_images')) {
            // Supprimer les images qui ne sont pas dans keep_images
            $imagesToDelete = $objet->images()->whereNotIn('id', $request->keep_images)->get();

            foreach ($imagesToDelete as $image) {
                $imagePath = public_path($image->url);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $image->delete();
            }
        } else {
            // Si aucune image n'est marquée à conserver, supprimer toutes les images existantes
            foreach ($objet->images as $image) {
                $imagePath = public_path($image->url);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $image->delete();
            }
        }

        // Gestion des nouvelles images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = 'objet_' . $objet->id . '_' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);

                $objet->images()->create([
                    'url' => 'images/' . $filename
                ]);
            }
        }

        return redirect()->route('objet.mes_objets')->with('success', 'Objet mis à jour avec succès');
    }

    public function toggleStatut($id)
    {
        $objet = Objet::where('proprietaire_id', Auth::id())
            ->findOrFail($id);

        $objet->update([
            'statut' => $objet->statut === 'active' ? 'archived' : 'active'
        ]);

        return back()->with('success', 'Statut de l\'objet mis à jour');
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
    public function show($id)
    {
        $objet = Objet::with(['images', 'proprietaire'])->findOrFail($id);

        // Récupérer les évaluations avec leurs données associées
        $evaluations = DB::table('evaluation')
            ->join('reservation', 'evaluation.reservation_id', '=', 'reservation.id')
            ->join('annonce', 'reservation.annonce_id', '=', 'annonce.id')
            ->join('users', 'evaluation.evaluateur_id', '=', 'users.id')
            ->select(
                'evaluation.*',
                'users.nom as evaluateur_nom',
                'users.prenom as evaluateur_prenom'
            )
            ->where('annonce.objet_id', $id)
            ->get();

        // Calcul note moyenne
        $note = $evaluations->avg('note_objet') ?? 0;

        // Vérifier disponibilité 
        $disponible = DB::table('annonce')
            ->where('objet_id', $id)
            ->where('statut', 'active')
            ->where('date_fin', '>=', now())
            ->exists();

        return view('fiches.objet', compact('objet', 'note', 'disponible', 'evaluations'));
    }
}

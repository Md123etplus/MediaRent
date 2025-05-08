<?php
namespace App\Http\Controllers;

use App\Models\Objet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ObjetDetailController extends Controller
{
    
    use AuthorizesRequests;
    public function show(Objet $objet) // Route Model Binding
    {
        $this->authorize('view', $objet);

        // Charger les relations pour éviter N+1 requêtes dans la vue si besoin
        $objet->load(['images', 'proprietaire', 'annonces' => function($query) {
            $query->where('statut', 'active') // Exemple pour ne charger que les annonces actives
                  ->where('date_fin', '>=', now()->toDateString());
        }]);

        // Informations requises: photo, note, prix par jour, disponibilité
        return view('details.objet', [
            'objet' => $objet,
            // 'photo_url' => $objet->main_image_url, // Via accesseur
            // 'note_objet' => $objet->average_rating, // Via accesseur
            // 'prix_par_jour' => $objet->prix_journalier,
            // 'disponibilite' => $objet->is_available // Via accesseur (simplifié)
        ]);
    }
}
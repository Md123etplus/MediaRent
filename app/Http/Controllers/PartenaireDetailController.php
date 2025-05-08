<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PartenaireDetailController extends Controller
{
    
    use AuthorizesRequests;
    public function show(User $partenaire) // Route Model Binding
    {
        if ($partenaire->role !== 'partenaire') {
            abort(404, 'Utilisateur non trouvé ou n\'est pas un partenaire.');
        }

        $this->authorize('view', $partenaire);

        $partenaire->loadCount(['annoncesAsProprietaire as nombre_annonces_recount']);
        $partenaire->loadAvg('evaluationsReceived as average_rating_recount', 'note');


        // Informations requises: surnom, note, nombre d’annonces
        return view('details.partenaire', [
            'partenaire' => $partenaire,
            // 'surnom' => $partenaire->surnom,
            // 'note' => $partenaire->average_rating,
            // 'nombre_annonces' => $partenaire->nombre_annonces
        ]);
    }
}
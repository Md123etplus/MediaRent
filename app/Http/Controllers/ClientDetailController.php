<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ClientDetailController extends Controller
{
    
    use AuthorizesRequests;
    
    public function show(User $client) // Utilise le Route Model Binding
    {
        // Vérifier si l'utilisateur cible est bien un client
        if ($client->role !== 'client') {
            abort(404, 'Utilisateur non trouvé ou n\'est pas un client.');
        }

        // Autorisation via Policy
        

        // Charger les données nécessaires avec eager loading pour optimiser
        $client->loadCount(['reservationsAsClient as nombre_locations_recount']); // Recalcule au cas où
        $client->loadAvg('evaluationsReceived as average_rating_recount', 'note');


        // Informations requises: surnom, note, nombre de locations
        return view('details.client', [
            'client' => $client,
            // 'surnom' => $client->surnom, // Via accesseur
            // 'note' => $client->average_rating, // Via accesseur
            // 'nombre_locations' => $client->nombre_locations // Via accesseur
        ]);
    }
}


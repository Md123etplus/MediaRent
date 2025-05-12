<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormClient;
use App\Models\User;

class ClientController extends Controller
{
    public function create()
    {
        return view('reservations.formClient'); // tu vas créer cette vue après
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|string|max:191',
        'prenom' => 'required|string|max:191',
        'email' => 'required|email|unique:users,email',
        //'mot_de_passe' => 'required|string|min:3',
        'CIN' => 'required|string|max:191|unique:users,CIN',
        //'img_profil' => 'required|image',
        //'img_cin_front' => 'required|image',
        //'img_cin_back' => 'required|image',
    ]);

    // Upload des images
   // $imgProfilPath = $request->file('img_profil')->store('img_profil', 'public');
    //$imgCinFrontPath = $request->file('img_cin_front')->store('img_cin', 'public');
    //$imgCinBackPath = $request->file('img_cin_back')->store('img_cin', 'public');

    \App\Models\FormClient::create([
        'nom' => $validated['nom'],
        'prenom' => $validated['prenom'],
        'email' => $validated['email'],
        //'mot_de_passe' => bcrypt($validated['mot_de_passe']),
        'role' => 'client',
        'CIN' => $validated['CIN'],
        //'img_profil' => $imgProfilPath,
        //'img_cin_front' => $imgCinFrontPath,
        //'img_cin_back' => $imgCinBackPath,
    ]);

    return redirect()->route('reservations.confirmation')->with('success', 'Compte créé avec succès !');
}

public function show(User $client) // Route Model Binding
    {
        if (!$client->isClient()) {
            abort(404, 'Client non trouvé.');
        }
        // Les données calculées sont dans les accesseurs du modèle User

        return view('fiches.client', compact('client'));
    }

}

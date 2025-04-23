<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce; 

class AnnonceController extends Controller
{
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
    
// Removed utilisateur method from the controller as it belongs in the model
}

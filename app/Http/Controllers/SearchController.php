<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Annonce::query()->with('objet', 'partenaire');

        if ($request->filled('ville')) {
            $query->where('ville', 'like', '%' . $request->ville . '%');
        }

        if ($request->filled('type')) {
            $query->whereHas('objet', function ($q) use ($request) {
                $q->where('type', 'like', '%' . $request->type . '%');
            });
        }

        if ($request->filled('prix_min')) {
            $query->where('prix_jour', '>=', $request->prix_min);
        }

        if ($request->filled('prix_max')) {
            $query->where('prix_jour', '<=', $request->prix_max);
        }

        if ($request->filled('note_min')) {
            $query->where('note_moyenne', '>=', $request->note_min);
        }

        $resultats = $query->paginate(10);

        return view('client.annonces.resultat', compact('resultats'));
    }
}

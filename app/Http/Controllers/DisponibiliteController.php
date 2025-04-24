<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Disponibilite;

class DisponibiliteController extends Controller
{
    public function index()
    {
        $dispos = Disponibilite::where('utilisateur_id', auth()->id())->get();
        return response()->json($dispos);
    }

    // Dans DisponibiliteController.php
public function store(Request $request)
{
    $request->validate([
        'objet_id' => 'required|exists:objets,id',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut'
    ]);

    $disponibilite = Disponibilite::create($request->all());
    $objet = Objet::find($request->objet_id);

    return response()->json([
        'success' => true,
        'date_debut' => $disponibilite->date_debut,
        'date_fin' => $disponibilite->date_fin,
        'objet_nom' => $objet->nom
    ]);
}

    public function destroy($id)
    {
        Disponibilite::where('id', $id)->where('utilisateur_id', auth()->id())->delete();
        return response()->json(['message' => 'Supprimé']);
    }
}

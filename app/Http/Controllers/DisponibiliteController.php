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

    public function store(Request $request)
    {
        $dispo = new Disponibilite();
        $dispo->utilisateur_id = auth()->id();
        $dispo->title = $request->title;
        $dispo->start = $request->start;
        $dispo->end = $request->end;
        $dispo->save();
        return response()->json(['message' => 'Créé']);
    }

    public function destroy($id)
    {
        Disponibilite::where('id', $id)->where('utilisateur_id', auth()->id())->delete();
        return response()->json(['message' => 'Supprimé']);
    }
}

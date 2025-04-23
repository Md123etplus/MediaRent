<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
use App\Models\Disponibilite; // Ensure this class exists in the specified namespace
use Illuminate\Support\Facades\Auth; // Ensure this class exists in the specified namespace
class DisponibiliteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $dispos = Disponibilite::where('utilisateur_id', $user->id)->get();
        } else {
            $dispos = [];
        }
        return response()->json($dispos);
    }

    public function store(Request $request)
    {
        $dispo = new Disponibilite();
        $dispo->utilisateur_id = Auth::id();
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
?>
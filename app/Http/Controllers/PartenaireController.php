<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartenaireController extends Controller
{
    public function show($id)
    {
        // Récupérer l'utilisateur sans vérifier son rôle
        $partenaire = User::findOrFail($id);

        // Récupérer les statistiques du partenaire
        $stats = [
            'nombre_objets' => DB::table('objet')
                ->where('proprietaire_id', $id)
                ->count(),

            'note_moyenne' => DB::table('evaluation')
                ->join('reservation', 'evaluation.reservation_id', '=', 'reservation.id')
                ->join('annonce', 'reservation.annonce_id', '=', 'annonce.id')
                ->join('objet', 'annonce.objet_id', '=', 'objet.id')
                ->where('objet.proprietaire_id', $id)
                ->avg('evaluation.note_proprietaire') ?? 0,

            'nombre_locations' => DB::table('reservation')
                ->join('annonce', 'reservation.annonce_id', '=', 'annonce.id')
                ->join('objet', 'annonce.objet_id', '=', 'objet.id')
                ->where('objet.proprietaire_id', $id)
                ->count()
        ];

        // Récupérer les objets du partenaire
        $objets = DB::table('objet')
            ->where('proprietaire_id', $id)
            ->leftJoin('image', 'objet.id', '=', 'image.objet_id')
            ->select('objet.*', 'image.url as image_url')
            ->get()
            ->unique('id');

        return view('partenaire.show', compact('partenaire', 'stats', 'objets'));
    }
}

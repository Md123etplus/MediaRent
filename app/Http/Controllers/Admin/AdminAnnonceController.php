<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Categorie;
use Carbon\Carbon;

class AdminAnnonceController extends Controller
{
    public function index($type)
    {
        // Statistiques générales
        $stats = [
            'total' => Annonce::count(),
            'active' => Annonce::where('statut', 'active')->count(),
            'pending' => Annonce::where('statut', 'pending')->count(),
            'premium' => Annonce::where('premium', true)->count(),
            'expired' => Annonce::where('date_fin', '<', now())->count(),
        ];

        // Données pour les graphiques
        $chartData = [
            'status' => [
                'labels' => ['Actives', 'En attente', 'Expirées'],
                'data' => [
                    $stats['active'],
                    $stats['pending'],
                    $stats['expired']
                ],
                'colors' => ['#10B981', '#F59E0B', '#6B7280']
            ],
            'categories' => $this->getCategoriesChartData()
        ];

        // Liste des annonces paginées
        if($type === "premium"){
            $annonces = Annonce::with(['objet', 'proprietaire'])
            ->where('premium', true)
            ->latest()
            ->paginate(10);
        }
        else if($type === "Archivée"){
            $annonces = Annonce::with(['objet', 'proprietaire'])
            ->where('statut', "Archivée")
            ->latest()
            ->paginate(10);
        }
        else{
            $annonces = Annonce::with(['objet', 'proprietaire'])
                ->latest()
                ->paginate(10);
        }

        return view('admin.annonces.index', compact('stats', 'chartData', 'annonces'));
    }

    private function getCategoriesChartData()
    {
        $categories = Categorie::withCount('objets')
            ->orderBy('objets_count', 'desc')
            ->limit(5)
            ->get();

        return [
            'labels' => $categories->pluck('nom'),
            'data' => $categories->pluck('objets_count'),
            'colors' => ['#3B82F6', '#6366F1', '#8B5CF6', '#A855F7', '#D946EF']
        ];
    }

    public function getDetails(Annonce $annonce)
    {
        $annonce->load(['objet.images', 'objet.categorie', 'proprietaire']);

        return response()->json([
            'success' => true,
            'html' => view('admin.components.annonce-details-content', compact('annonce'))->render()
        ]);
    }

    // Dans AnnonceController.php
public function toggleArchive($id)
{
    $annonce = Annonce::findOrFail($id);

    // Vérification des permissions
    // if ($annonce->proprietaire_id != auth()->id() && !auth()->user()->isAdmin()) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Action non autorisée'
    //     ], 403);
    // }

    // Toggle du statut
    $newStatus = $annonce->statut === 'Archivée' ? 'Anctive' : 'Archivée';
    $annonce->statut = $newStatus;
    $annonce->save();

    return response()->json([
        'success' => true,
        'message' => $newStatus === 'Archivée' ? 'Annonce Archivée' : 'Annonce réactivée',
        'new_status' => $newStatus,
        'new_status_label' => ucfirst($newStatus),
        'new_button_text' => $newStatus === 'Archivée' ? 'Réactiver' : 'Archiver',
        'new_button_class' => $newStatus === 'Archivée' ? 'text-green-100 bg-green-800' : 'text-red-100 bg-red-800'
    ]);
}
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Evaluation;
use Carbon\Carbon;

class AdminEvaluationController extends Controller
{
    public function index()
    {
        // Top 5 annonces les mieux notées
        $topAnnonces = Annonce::with(['objet', 'proprietaire'])
            ->withAvg('evaluations as moyenne_notes', 'notet')
            ->withCount('evaluations')
            ->whereHas('evaluations')
            ->orderByDesc('moyenne_notes')
            ->take(5)
            ->get()
            ->map(function($annonce) {
                $annonce->revenu_total = $annonce->reservations()
                    ->where('statut', 'confirmée')
                    ->get()
                    ->sum(function($res) {
                        return $res->duration_days * $res->annonce->objet->prix_journalier;
                    });
                return $annonce;
            });

        // Dernières évaluations pour chaque top annonce
        $evaluationsParAnnonce = $topAnnonces->mapWithKeys(function($annonce) {
            return [
                $annonce->id => $annonce->evaluations()
                    ->with(['evaluateur', 'objet'])
                    ->latest()
                    ->take(5)
                    ->get()
            ];
        });

        // Statistiques globales
        $stats = [
            'total_evaluations' => Evaluation::count(),
            'moyenne_generale' => round(Evaluation::avg('note'), 1),
            'evaluations_ce_mois' => Evaluation::whereMonth('created_at', now()->month)->count(),
            'pourcentage_positives' => round(Evaluation::where('note', '>=', 4)->count() / max(1, Evaluation::count()) * 100),
        ];

        // Données pour les graphiques
        $chartData = $this->prepareChartData();

        // Toutes les évaluations paginées
        $allEvaluations = Evaluation::with(['evaluateur', 'evalue', 'objet'])
            ->latest()
            ->paginate(20);

        return view('admin.evaluations.index', compact(
            'topAnnonces',
            'evaluationsParAnnonce',
            'stats',
            'chartData',
            'allEvaluations'
        ));
    }

    public function toggleVisibility(Evaluation $evaluation)
    {
        try {
            $newVisibility = !$evaluation->is_visible;
            $evaluation->update(['is_visible' => $newVisibility]);

            return response()->json([
                'success' => true,
                'is_visible' => $newVisibility,
                'message' => $newVisibility
                    ? 'L\'évaluation est maintenant visible'
                    : 'L\'évaluation est maintenant masquée'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }

    private function prepareChartData()
    {
        // Répartition par note
        $notesDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $notesDistribution[$i] = Evaluation::where('note', $i)->count();
        }

        // Évolutions mensuelles
        $monthlyData = Evaluation::selectRaw('
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                COUNT(*) as count,
                AVG(note) as avg_note
            ')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $labels = $monthlyData->map(function($item) {
            return Carbon::create($item->year, $item->month)->format('M Y');
        });

        return [
            'notes_distribution' => [
                'labels' => array_keys($notesDistribution),
                'data' => array_values($notesDistribution),
            ],
            'monthly_trends' => [
                'labels' => $labels,
                'counts' => $monthlyData->pluck('count'),
                'avg_notes' => $monthlyData->pluck('avg_note'),
            ]
        ];
    }
}

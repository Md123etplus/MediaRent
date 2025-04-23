<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Objet;
use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\Evaluation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Dates pour les filtres
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Statistiques principales
        $stats = [
            // Utilisateurs
            'total_users' => User::count(),
            'new_users_month' => User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'new_users_week' => User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(),
            'users_growth' => $this->calculateGrowthRate(User::class),

            // Objets et annonces
            'total_objets' => Objet::count(),
            'annonces' => Annonce::count(),
            'premium_annonces' => Annonce::where('premium', true)->count(),
            'premium_growth' => $this->calculateGrowthRate(Annonce::class, ['premium' => true]),

            // Réservations et revenus
            'total_reservations' => Reservation::count(),
            'current_month_reservations' => Reservation::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'revenue_month' => $this->calculateMonthlyRevenue(),
            'revenue_week' => $this->calculateWeeklyRevenue(),

            // Evaluations
            'total_evaluations' => Evaluation::count(),
            'avg_rating' => Evaluation::avg('note') ?? 0,
            'new_evaluations' => Evaluation::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(),
        ];

        // Derniers utilisateurs inscrits (7 derniers jours)
        $newUsers = User::withCount(['reservations as total_reservations'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Derniers avis (évaluations)
        $recentReviews = Evaluation::with(['evaluateur', 'objet'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Dernières annonces premium
        $premiumAnnonces = Annonce::with(['objet', 'proprietaire'])
            ->where('premium', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Dernières réservations
        $latestReservations = Reservation::with(['client', 'annonce.objet'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'newUsers',
            'recentReviews',
            'premiumAnnonces',
            'latestReservations'
        ));
    }

    /**
     * Calcule le taux de croissance mensuel
     */
    private function calculateGrowthRate($model, $conditions = [])
    {
        $currentMonthCount = $model::where($conditions)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $previousMonthCount = $model::where($conditions)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        if ($previousMonthCount == 0) {
            return 0;
        }

        return round((($currentMonthCount - $previousMonthCount) / $previousMonthCount) * 100, 2);
    }

    /**
     * Calcule le revenu du mois en cours
     */
    private function calculateMonthlyRevenue()
    {
        return Reservation::confirmed()
            ->betweenDates(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth())
            ->get()
            ->sum('revenue');
    }

    private function calculateWeeklyRevenue()
    {
        return Reservation::confirmed()
            ->betweenDates(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek())
            ->get()
            ->sum('revenue');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Statistiques utilisateurs
        $stats = [
            'total' => User::count(),
            'clients' => User::where('role', 'client')->count(),
            'partenaires' => User::where('role', 'partenaire')->count(),
            'new_this_month' => User::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        // Données pour les graphiques
        $chartData = [
            'registration' => $this->getRegistrationChartData(),
            'roles' => [
                'labels' => ['Clients', 'Partenaires'],
                'data' => [$stats['clients'], $stats['partenaires']]
            ]
        ];

        // Liste des utilisateurs paginés
        $users = User::withCount(['reservations as total_reservations'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('admin.users.index', compact('stats', 'chartData', 'users'));
    }

    private function getRegistrationChartData()
    {
        $months = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('M Y');
            $data[] = User::whereYear('created_at', $month->year)
                         ->whereMonth('created_at', $month->month)
                         ->count();
        }

        return [
            'labels' => $months,
            'data' => $data
        ];
    }

    public function toggleSuspension(User $user)
    {
        $isSuspended = $user->toggleSuspension();
        
        return back()->with('success', 
            $isSuspended 
                ? 'Utilisateur suspendu avec succès' 
                : 'Utilisateur réactivé avec succès'
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

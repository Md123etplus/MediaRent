@extends('admin.layouts.admin')

@section('content')
<div class="flex flex-col flex-1 overflow-hidden">

    <!-- Page content -->
    <div class="flex-1 overflow-auto p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Gestion des Utilisateurs</h1>
            <p class="text-gray-600 dark:text-gray-300">Liste et statistiques des utilisateurs</p>
        </div>

        <!-- Stats cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            @include('admin.components.stats-card', [
                'title' => 'Total Utilisateurs',
                'value' => $stats['total'],
                'icon' => 'users',
                'trend' => '+'.$stats['new_this_month'],
                'trendColor' => 'green',
                'description' => 'ce mois-ci'
            ])

            @include('admin.components.stats-card', [
                'title' => 'Clients',
                'value' => $stats['clients'],
                'icon' => 'user',
                'trend' => '',
                'trendColor' => 'blue',
                'description' => 'utilisateurs standard'
            ])

            @include('admin.components.stats-card', [
                'title' => 'Partenaires',
                'value' => $stats['partenaires'],
                'icon' => 'user-tie',
                'trend' => '',
                'trendColor' => 'indigo',
                'description' => 'propriétaires de matériel'
            ])
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-3">
            <!-- Inscriptions par mois -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Inscriptions par mois</h2>
                <canvas id="registrationsChart" height="200"></canvas>
            </div>

            <!-- Répartition par rôle -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Répartition par rôle</h2>
                <canvas id="rolesChart" height="200"></canvas>
            </div>
        </div>

        <!-- Users list -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">Liste des utilisateurs</h2>
                <div class="relative w-64">
                    <input type="text" class="w-full pl-10 pr-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Rechercher...">
                    <div class="absolute left-3 top-2.5">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($users as $user)
                    @include('admin.components.user-item', [
                        'image' => $user->img_profil ?? 'https://via.placeholder.com/40',
                        'name' => $user->prenom.' '.$user->nom,
                        'email' => $user->email,
                        'date' => $user->created_at->format('d/m/Y'),
                        'role' => $user->role == 'partenaire' ? 'Partenaire' : 'Client',
                        'roleColor' => $user->role == 'partenaire' ? 'blue' : 'green',
                        'reservations' => $user->total_reservations,
                        'status' => $user->status ?? 'active',
                        'isSuspended' => $user->is_suspended,
                        'id' => $user->id
                    ])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    console.log('Données registration:', @json($chartData['registration']));
    console.log('Données roles:', @json($chartData['roles']));
    // Chart Inscriptions
    new Chart(document.getElementById('registrationsChart'), {
        type: 'line',
        data: {
            labels: @json($chartData['registration']['labels']),
            datasets: [{
                label: 'Nouveaux utilisateurs',
                data: @json($chartData['registration']['data']),
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });

    // Chart Rôles
    new Chart(document.getElementById('rolesChart'), {
        type: 'doughnut',
        data: {
            labels: @json($chartData['roles']['labels']),
            datasets: [{
                data: @json($chartData['roles']['data']),
                backgroundColor: ['#10B981', '#3B82F6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
@endsection

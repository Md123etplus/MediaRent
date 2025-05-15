@extends('admin.layouts.admin')

@section('content')
<div class="flex flex-col flex-1 overflow-hidden">

    <div class="flex items-center justify-between h-16 px-4 mb-3 bg-white border-b border-gray-200">
        <div class="flex items-center">
            <!-- Bouton du menu -->
            <button id="mobile-menu-button" class="text-gray-500 focus:outline-none md:hidden">
                <i class="fas fa-bars"></i>
            </button>
            <div class="relative mx-4">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" class="w-full py-2 pl-10 pr-4 text-sm text-gray-700 bg-gray-100 border border-transparent rounded-lg focus:bg-white focus:border-indigo-500 focus:outline-none" placeholder="Rechercher...">
            </div>
        </div>
        <div class="flex items-center">
            <button class="p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none">
                <i class="fas fa-bell"></i>
            </button>
            <div class="ml-4">
                <img class="w-8 h-8 rounded-full" src="https://via.placeholder.com/32" alt="User">
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-auto p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Gestion des Évaluations</h1>
            <p class="text-gray-600 dark:text-gray-300">Statistiques et modération des commentaires</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            @include('admin.components.stats-card', [
                'title' => 'Total Évaluations',
                'value' => $stats['total_evaluations'],
                'icon' => 'star',
                'description' => 'Depuis le début',

            ])

            @include('admin.components.stats-card', [
                'title' => 'Note Moyenne',
                'value' => $stats['moyenne_generale'],
                'icon' => 'star-half-alt',
                'description' => 'Sur 5 étoiles',

            ])

            @include('admin.components.stats-card', [
                'title' => 'Évaluations ce mois',
                'value' => $stats['evaluations_ce_mois'],
                'icon' => 'chart-line',
                'description' => 'Activité récente',

            ])

            @include('admin.components.stats-card', [
                'title' => 'Positives (4+)',
                'value' => $stats['pourcentage_positives'].'%',
                'icon' => 'thumbs-up',
                'description' => 'Note ≥ 4/5',

            ])
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Distribution des notes -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Répartition des Notes</h2>
                <canvas id="notesDistributionChart" height="250"></canvas>
            </div>

            <!-- Évolution mensuelle -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Évolution Mensuelle</h2>
                <canvas id="monthlyTrendsChart" height="250"></canvas>
            </div>
        </div>

        <!-- Top Annonces Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">Top 5 Annonces</h2>
            </div>

            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($topAnnonces as $annonce)
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-lg">{{ $annonce->objet->nom }}</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Note: {{ round($annonce->moyenne_notes, 1) }}/5 ({{ $annonce->evaluations_count }} avis) |
                                    Revenu: {{ number_format($annonce->revenu_total, 2) }} €
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                #{{ $loop->iteration }}
                            </span>
                        </div>

                        <div class="mt-4">
                            <h4 class="text-sm font-medium mb-2">5 Dernières Évaluations:</h4>
                            <div class="space-y-3">
                                @forelse($evaluationsParAnnonce[$annonce->id] ?? [] as $evaluation)
                                    @include('admin.components.review-item', [
                                        'image' => $evaluation->evaluateur->img_profil ?? 'https://via.placeholder.com/40',
                                        'user' => $evaluation->evaluateur->full_name,
                                        'rating' => $evaluation->note_objet,
                                        'comment' => $evaluation->commentaire_objet,
                                        'item' => $evaluation->objet->nom,
                                        'date' => $evaluation->created_at->format('d/m/Y'),
                                        'is_visible' => $evaluation->is_visible,
                                        'actions' => true,
                                        'id' => $evaluation->id
                                    ])
                                @empty
                                    <p class="text-gray-500 text-sm">Aucune évaluation récente</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- All Evaluations Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Toutes les Évaluations</h2>
                <div class="relative w-64">
                    <input type="text" placeholder="Rechercher..." class="w-full pl-10 pr-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <div class="absolute left-3 top-2.5">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($allEvaluations as $evaluation)
                    @include('admin.components.review-item', [
                        'image' => $evaluation->evaluateur->img_profil ?? 'https://via.placeholder.com/40',
                        'user' => $evaluation->evaluateur->full_name,
                        'rating' => $evaluation->note_objet,
                        'comment' => $evaluation->commentaire_objet,
                        'item' => $evaluation->objet ? $evaluation->objet->nom : 'Utilisateur',
                        'date' => $evaluation->created_at->format('d/m/Y'),
                        'is_visible' => $evaluation->is_visible,
                        'actions' => true,
                        'id' => $evaluation->id
                    ])
                @endforeach
            </div>

            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700">
                {{ $allEvaluations->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart 1: Distribution des notes
new Chart(document.getElementById('notesDistributionChart'), {
    type: 'bar',
    data: {
        labels: @json($chartData['notes_distribution']['labels']),
        datasets: [{
            label: 'Nombre d\'évaluations',
            data: @json($chartData['notes_distribution']['data']),
            backgroundColor: [
                'rgba(239, 68, 68, 0.7)', // 1 - red
                'rgba(249, 115, 22, 0.7)', // 2 - orange
                'rgba(234, 179, 8, 0.7)',  // 3 - yellow
                'rgba(34, 197, 94, 0.7)',  // 4 - green
                'rgba(16, 185, 129, 0.7)'  // 5 - emerald
            ],
            borderColor: [
                'rgba(239, 68, 68, 1)',
                'rgba(249, 115, 22, 1)',
                'rgba(234, 179, 8, 1)',
                'rgba(34, 197, 94, 1)',
                'rgba(16, 185, 129, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Nombre d\'évaluations'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Note (étoiles)'
                }
            }
        }
    }
});

// Chart 2: Évolution mensuelle
new Chart(document.getElementById('monthlyTrendsChart'), {
    type: 'line',
    data: {
        labels: @json($chartData['monthly_trends']['labels']),
        datasets: [
            {
                label: 'Nombre d\'évaluations',
                data: @json($chartData['monthly_trends']['counts']),
                borderColor: 'rgba(79, 70, 229, 1)',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.3,
                yAxisID: 'y'
            },
            {
                label: 'Note moyenne',
                data: @json($chartData['monthly_trends']['avg_notes']),
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.3,
                yAxisID: 'y1'
            }
        ]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Nombre d\'évaluations'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                min: 1,
                max: 5,
                title: {
                    display: true,
                    text: 'Note moyenne'
                },
                grid: {
                    drawOnChartArea: false,
                }
            }
        }
    }
});

</script>
@endpush
@endsection

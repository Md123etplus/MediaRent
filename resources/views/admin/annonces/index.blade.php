@extends('admin.layouts.admin')

@section('content')
<div class="flex flex-col flex-1 overflow-hidden">

    <!-- Main Content -->
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Top navigation -->
        <div class="flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200">
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

    <!-- Page content -->
    <div class="flex-1 overflow-auto p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Gestion des Annonces</h1>
            <p class="text-gray-600 dark:text-gray-300">Statistiques et liste des annonces</p>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Statut des annonces -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Statut des annonces</h2>
                <canvas id="statusChart" height="250"></canvas>
            </div>

            <!-- Catégories populaires -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Top catégories</h2>
                <canvas id="categoriesChart" height="250"></canvas>
            </div>
        </div>

        <!-- Annonces list -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">Liste des annonces</h2>
                <div class="flex space-x-2">
                    <select class="text-sm rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option>Tous les statuts</option>
                        <option>Actives</option>
                        <option>En attente</option>
                        <option>Expirées</option>
                    </select>
                    <div class="relative w-64">
                        <input type="text" class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Rechercher...">
                        <div class="absolute left-3 top-2.5">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($annonces as $annonce)
                    @include('admin.components.listing-item', [
                        'id' => $annonce->id,
                        'title' => $annonce->objet->nom,
                        'status' => $annonce->statut === 'active' ? 'Active' :
                                ($annonce->statut === 'pending' ? 'Pending' :
                                ($annonce->statut === 'expired' ? 'Expired' :
                                ($annonce->statut === 'rejected' ? 'Rejected' : ucfirst($annonce->statut)))),
                        'location' => $annonce->objet->ville,
                        'price' => '€'.$annonce->objet->prix_journalier.'/jour',
                        'date' => 'Jusqu\'au '.$annonce->date_fin->format('d/m/Y'),
                        'reservations' => $annonce->reservations_count.' réservation'.($annonce->reservations_count > 1 ? 's' : ''),
                        'premium' => $annonce->premium,
                        'thumbnail' => $annonce->objet->images->first()->url ?? null,
                        'actions' => true
                ])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700">
                {{ $annonces->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Statut
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: @json($chartData['status']['labels']),
            datasets: [{
                data: @json($chartData['status']['data']),
                backgroundColor: @json($chartData['status']['colors']),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'right' }
            }
        }
    });

    // Chart Catégories
    new Chart(document.getElementById('categoriesChart'), {
        type: 'bar',
        data: {
            labels: @json($chartData['categories']['labels']),
            datasets: [{
                label: 'Nombre d\'annonces',
                data: @json($chartData['categories']['data']),
                backgroundColor: @json($chartData['categories']['colors']),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush
@endsection

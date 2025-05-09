@extends('admin.layouts.admin')

@section('content')
<div class="flex flex-col flex-1 overflow-hidden">

    <div class="flex-1 overflow-auto p-6">
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

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Gestion des Réservations</h1>
            <p class="text-gray-600 dark:text-gray-300">Statistiques réservations</p>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Confirmées</p>
                <p class="text-2xl font-bold text-green-500">{{ $stats['confirmed'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">En attente</p>
                <p class="text-2xl font-bold text-yellow-500">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Annulées</p>
                <p class="text-2xl font-bold text-red-500">{{ $stats['cancelled'] }}</p>
            </div>
        </div>

        <!-- Liste des réservations -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-medium">Toutes les réservations</h2>
                <div class="flex space-x-2">
                    <select id="statusFilter" class="rounded-lg border-gray-300 text-sm dark:bg-gray-700 dark:border-gray-600">
                        <option value="all">Toutes</option>
                        <option value="confirmée">Confirmées</option>
                        <option value="en_attente">En attente</option>
                        <option value="annulée">Annulées</option>
                    </select>
                    <a href="{{ route('admin.export', ['type' => 'reservations']) }}" class="px-3 py-1 bg-indigo-600 text-white rounded-lg text-sm">
                        Exporter
                    </a>
                </div>
            </div>

            <div id="reservationsContainer" class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($reservations as $reservation)
                    <div class="reservation-item" data-status="{{ $reservation->statut }}">
                        @include('admin.components.reservation-item', [
                        'image' => $reservation->annonce->objet->images->first()->url ?? 'https://via.placeholder.com/40',
                        'item' => $reservation->annonce->objet->nom,
                        'user' => $reservation->client->prenom.' '.$reservation->client->nom,
                        'price' => '€'.$reservation->annonce->objet->prix_journalier.'/jour',
                        'dates' => Carbon\Carbon::parse($reservation->date_debut)->format('d-m-Y').' - '.Carbon\Carbon::parse($reservation->date_fin)->format('d-m-Y'),
                        'status' => $reservation->statut
                        ])
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('statusFilter');
    const reservationItems = document.querySelectorAll('.reservation-item');

    statusFilter.addEventListener('change', function() {
        const selectedStatus = this.value;

        reservationItems.forEach(item => {
            if (selectedStatus === 'all' || item.dataset.status === selectedStatus) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
@endsection

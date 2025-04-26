@extends('client.dashboard')

@section('client-content')
<div class="dashboard-card">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="dashboard-card-header">Historique de mes réservations</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Retrouvez toutes vos locations passées et en cours</p>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
        <form method="GET" action="{{ route('client.reservations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Recherche</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                       placeholder="Nom de l'objet">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Statut</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Tous les statuts</option>
                    <option value="en attente" {{ request('status') == 'en attente' ? 'selected' : '' }}>En attente</option>
                   
                    <option value="terminée" {{ request('status') == 'terminée' ? 'selected' : '' }}>Terminée</option>
                    <option value="annulée" {{ request('status') == 'annulée' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">À partir du</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Appliquer
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des réservations -->
    <div class="overflow-hidden rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        @if($recentReservations->count() > 0)
            <div class="grid grid-cols-1 gap-4 p-4">
                @foreach($recentReservations as $reservation)
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all hover:shadow-md">
                        <div class="p-5">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <!-- Info objet -->
                                <div class="flex items-start space-x-4 mb-4 md:mb-0">
                                    <div class="flex-shrink-0 h-20 w-20 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-600">
                                        <img src="{{ $reservation->annonce->objet->images->first()->url ?? '/images/placeholder.png' }}" 
                                             alt="{{ $reservation->annonce->objet->nom }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $reservation->annonce->objet->nom }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            <span class="font-medium">Propriétaire:</span> 
                                            {{ $reservation->annonce->proprietaire->prenom }} {{ $reservation->annonce->proprietaire->nom }}
                                        </p>
                                        <div class="flex items-center mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400 dark:text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $reservation->annonce->objet->ville }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Dates et prix -->
                                <div class="flex flex-col space-y-2">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400 dark:text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }} - 
                                            {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                                            @php
                                                $days = \Carbon\Carbon::parse($reservation->date_debut)->diffInDays($reservation->date_fin);
                                                $total = $days * $reservation->annonce->objet->prix_journalier;
                                            @endphp
                                            {{ number_format($total, 2) }} €
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Statut et actions -->
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center mb-3 md:mb-0">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $reservation->statut === 'confirmée' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                           ($reservation->statut === 'en attente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                           ($reservation->statut === 'terminée' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                           'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200')) }}">
                                        {{ $reservation->statut }}
                                    </span>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <a href="{{ route('client.reservations.show', $reservation->id) }}" 
                                       class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        Détails
                                    </a>
                                    
                                    @if($reservation->statut === 'terminée')
    @if($reservation->evaluation)
        <!-- Afficher l'évaluation existante -->
        <div class="mt-4">
            <p>Note: {{ $reservation->evaluation->note }}/5</p>
            <p>Commentaire: {{ $reservation->evaluation->commentaire }}</p>
        </div>
    @else
        <!-- Afficher le bouton pour évaluer -->
        <a href="{{ route('client.evaluations.create', $reservation->id) }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Évaluer cette réservation
        </a>
    @endif
@endif
                                    
                                    @if($reservation->statut === 'en attente')
                                        <form action="{{ route('client.reservations.cancel', $reservation->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-red-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                Annuler
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Affichage de <span class="font-medium">{{ $recentReservations->firstItem() }}</span> à <span class="font-medium">{{ $recentReservations->lastItem() }}</span> sur <span class="font-medium">{{ $recentReservations->total() }}</span> réservations
                </div>
                <div>
                    {{ $recentReservations->links() }}
                </div>
            </div>
        @else
            <div class="px-6 py-8 text-center">
                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-lg">Aucune réservation trouvée</p>
                    <p class="text-sm mt-1">Vous n'avez pas encore effectué de réservation</p>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .dashboard-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .dark .dashboard-card {
        background: #1f2937;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }
    
    .dashboard-card-header {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
    }
    
    .dark .dashboard-card-header {
        color: #f9fafb;
    }
    
    /* Animation pour les cartes de réservation */
    .reservation-card {
        transition: all 0.2s ease;
    }
    
    .reservation-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    /* Style pour les étoiles de notation */
    .star-rating {
        display: inline-flex;
    }
    
    .star-rating svg {
        width: 1.25rem;
        height: 1.25rem;
    }
    
    /* Style pour la pagination */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
    }
    
    .pagination li {
        margin: 0 0.25rem;
    }
    
    .pagination a, .pagination span {
        display: inline-block;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        border: 1px solid #d1d5db;
        color: #374151;
        text-decoration: none;
    }
    
    .pagination a:hover {
        background-color: #f3f4f6;
    }
    
    .pagination .active span {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    
    .dark .pagination a, .dark .pagination span {
        border-color: #4b5563;
        color: #d1d5db;
    }
    
    .dark .pagination a:hover {
        background-color: #374151;
    }
    
    .dark .pagination .active span {
        background-color: #1d4ed8;
        border-color: #1d4ed8;
    }
</style>
@endsection
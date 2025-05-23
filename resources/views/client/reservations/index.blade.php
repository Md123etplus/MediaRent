@extends('client.dashboard')  
@section('client-content') 
<div class="dashboard-card backdrop-filter backdrop-blur-sm bg-white/90 dark:bg-gray-800/90 border border-gray-100 dark:border-gray-700 shadow-xl rounded-2xl">     
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">         
        <div>             
            <h2 class="dashboard-card-header text-2xl font-bold relative inline-block">
                <span class="bg-gradient-to-r from-violet-600 to-indigo-500 bg-clip-text text-transparent">Mes Réservations</span>
                <span class="absolute -bottom-1 left-0 w-1/3 h-1 bg-gradient-to-r from-violet-600 to-indigo-500 rounded-full"></span>
            </h2>             
            <p class="text-gray-600 dark:text-gray-300 mt-2 font-light flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                </svg>
                Consultez facilement toutes vos locations, passées ou en cours, en un seul endroit.
            </p>         
        </div>     
    </div>  

   <!-- Filtres et recherche -->
<div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-inner">
    <form method="GET" action="{{ route('client.reservations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Recherche -->
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Recherche</label>
            <div class="relative">
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       class="w-full pl-10 pr-3 py-2 border-0 focus:ring-2 ring-offset-2 ring-offset-blue-50 dark:ring-offset-gray-800 ring-blue-500 rounded-lg shadow-sm focus:outline-none dark:bg-gray-700 dark:text-white transition-all duration-200" 
                       placeholder="Nom ou ville">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>
        </div>

        <!-- Statut -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Statut</label>
            <div class="relative">
                <select name="status" id="status" class="w-full pl-3 pr-10 py-2 border-0 focus:ring-2 ring-offset-2 ring-offset-blue-50 dark:ring-offset-gray-800 ring-blue-500 rounded-lg shadow-sm focus:outline-none appearance-none dark:bg-gray-700 dark:text-white transition-all duration-200">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" {{ request('status') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="confirmée" {{ request('status') == 'confirmée' ? 'selected' : '' }}>Confirmée</option>
                    <option value="annulée" {{ request('status') == 'annulée' ? 'selected' : '' }}>Annulée</option>
                    
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Date de début -->
        <div>
            <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">À partir du</label>
            <div class="relative">
               <!-- Assurez-vous que le format est YYYY-MM-DD -->
<input type="date" name="date_from" id="date_from" 
       value="{{ request('date_from') }}"
       class="w-full pl-10 pr-3 py-2 border-0 focus:ring-2 ring-offset-2 ring-offset-blue-50 dark:ring-offset-gray-800 ring-blue-500 rounded-lg shadow-sm focus:outline-none dark:bg-gray-700 dark:text-white transition-all duration-200">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>
        </div>

        <!-- Bouton Appliquer -->
        <div class="flex items-end space-x-4">
            <button type="submit" class="w-full px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <span class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Appliquer
                </span>
            </button>
            
            @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                <a href="{{ route('client.reservations.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200 flex items-center">
                    Réinitialiser
                </a>
            @endif
        </div>
    </form>
</div>

    <!-- Liste des réservations -->
    <div class="overflow-hidden rounded-xl shadow">
        @if($recentReservations->count() > 0)
            <div class="grid grid-cols-1 gap-6 p-6">
                @foreach($recentReservations as $reservation)
               
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-xl hover:border-blue-300 dark:hover:border-blue-500 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <!-- Info objet -->
                                <div class="flex items-start space-x-5 mb-6 md:mb-0">
                                <div class="flex-shrink-0 h-24 w-24 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-600 shadow-md">
    @php
        $objetId = $reservation->annonce->objet->id;
        $imagePath = "images/objet_$objetId.jpg";
        $absolutePath = public_path($imagePath);
        
        if(!File::exists($absolutePath)) {
            $imagePath = 'images/placeholder.png';
        }
    @endphp

    <img src="{{ asset($imagePath) }}" 
         alt="{{ $reservation->annonce->objet->nom }}"
         class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
</div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $reservation->annonce->objet->nom }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 flex items-center">
                                            <span class="inline-block h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-500 dark:text-blue-300 flex items-center justify-center mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                                </svg>
                                            </span>
                                            <span class="font-medium">{{ $reservation->annonce->proprietaire->prenom }} {{ $reservation->annonce->proprietaire->nom }}</span>
                                        </p>
                                        <div class="flex items-center mt-2">
                                            <span class="inline-block h-8 w-8 rounded-full bg-green-100 dark:bg-green-900 text-green-500 dark:text-green-300 flex items-center justify-center mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $reservation->annonce->objet->ville }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Dates et prix -->
                                <div class="flex flex-col space-y-3 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-inner">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500 dark:text-indigo-300" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300 font-medium">
                                            {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }} - 
                                            {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $days = \Carbon\Carbon::parse($reservation->date_debut)->diffInDays($reservation->date_fin);
                                            $total = $days * $reservation->annonce->objet->prix_journalier;
                                        @endphp
                                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                            {{ number_format($total, 2) }} MAD
                                        </span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">pour {{ $days }} jour(s)</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Statut et actions -->
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center mb-4 md:mb-0">
                                    <span class="px-4 py-1.5 inline-flex text-sm leading-5 font-bold rounded-full 
                                        {{ $reservation->statut === 'confirmée' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                           ($reservation->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                           'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                        <span class="flex items-center">
                                            @if($reservation->statut === 'confirmée')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            @elseif($reservation->statut === 'en_attente')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                            {{ $reservation->statut }}
                                        </span>
                                    </span>
                                </div>
                                
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('client.reservations.show', $reservation->id) }}" 
                                       class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        Détails
                                    </a>
                                    @if($reservation->statut === 'confirmée' || $reservation->statut === 'évaluée')
    <div class="flex items-center space-x-2">
        @if($reservation->statut === 'évaluée' && $reservation->evaluation)
            <a href="{{ route('client.evaluations.show', $reservation->evaluation->id) }}"
               class="px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-500 text-white rounded-lg hover:from-purple-600 hover:to-indigo-600 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Voir évaluation
            </a>
        @else
            <button onclick="openEvaluationFormModal({{ $reservation->id }})"
                class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                Évaluer
            </button>
        @endif
    </div>
@endif
                                    
                                    @if($reservation->statut === 'en_attente')
                                        <form action="{{ route('client.reservations.cancel', $reservation->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:from-red-600 hover:to-pink-600 focus:ring-2 focus:ring-red-500 focus:outline-none transition-all duration-200 transform hover:scale-105 flex items-center">
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
            @else
    <div class="p-8 text-center bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200 mb-2">
            @if(request()->hasAny(['search', 'status', 'date_from']))
                Aucune réservation ne correspond à vos critères
            @else
                Vous n'avez aucune réservation pour le moment
            @endif
        </h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
            @if(request()->hasAny(['search', 'status', 'date_from']))
                Essayez d'ajuster vos filtres ou de rechercher d'autres termes.
            @else
                Lorsque vous ferez une réservation, elle apparaîtra ici.
            @endif
        </p>
        
        @if(request()->hasAny(['search', 'status', 'date_from']))
            <a href="{{ route('client.reservations.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
                Réinitialiser les filtres
            </a>
        @else
            <a href="{{ route('annonces.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
                Parcourir les annonces
            </a>
        @endif
    </div>
@endif
          

    <!-- Modal pour le formulaire d'évaluation -->
    <div id="evaluationFormModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-filter backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 w-full max-w-lg transform transition-all duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Évaluer la réservation</h3>
                <button onclick="closeEvaluationFormModal()" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form id="evaluationForm" method="POST" action="" onsubmit="submitEvaluationForm(event)">
                @csrf
                <input type="hidden" name="reservation_id" id="reservation_id" value="">
                
                <div class="space-y-6">
                    <!-- Note objet -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <label class="block font-medium mb-3 text-gray-800 dark:text-gray-200">Note pour l'objet</label>
                        <div class="flex items-center space-x-2" id="objetRating">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-10 h-10 cursor-pointer text-gray-300 dark:text-gray-600 rating-star hover:text-yellow-400 transition-colors duration-200" data-rating="{{ $i }}" data-target="objet" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        <input type="hidden" name="note_objet" id="note_objet" value="0">
                        <textarea name="commentaire_objet" placeholder="Partagez votre expérience avec cet objet..." class="mt-4 w-full px-4 py-3 border-0 rounded-lg shadow-inner focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-600 dark:text-white transition-all duration-200" rows="3"></textarea>
                    </div>
                    
                    <!-- Note propriétaire -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <label class="block font-medium mb-3 text-gray-800 dark:text-gray-200">Note pour le propriétaire</label>
                        <div class="flex items-center space-x-2" id="proprietaireRating">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-10 h-10 cursor-pointer text-gray-300 dark:text-gray-600 rating-star hover:text-yellow-400 transition-colors duration-200" data-rating="{{ $i }}" data-target="proprietaire" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        <input type="hidden" name="note_proprietaire" id="note_proprietaire" value="0">
                        <textarea name="commentaire_proprietaire" placeholder="Décrivez votre expérience avec le propriétaire..." class="mt-4 w-full px-4 py-3 border-0 rounded-lg shadow-inner focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-600 dark:text-white transition-all duration-200" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="closeEvaluationFormModal()" class="px-6 py-3 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-all duration-200 font-medium">
                        Annuler
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105 font-medium">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Envoyer l'évaluation
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



       

<script>
    
     
    // Fonctions pour le formulaire d'évaluation
function openEvaluationFormModal(reservationId) {
    document.getElementById('reservation_id').value = reservationId;
    // Mise à jour de l'action du formulaire avec l'ID de réservation
    document.getElementById('evaluationForm').action = `/client/evaluations/store/${reservationId}`;
    document.getElementById('evaluationFormModal').classList.remove('hidden');
}

function closeEvaluationFormModal() {
    document.getElementById('evaluationFormModal').classList.add('hidden');
    resetRatingStars();
}

function resetRatingStars() {
    // Réinitialiser les étoiles
    document.querySelectorAll('.rating-star').forEach(star => {
        star.classList.remove('text-yellow-400');
        star.classList.add('text-gray-300', 'dark:text-gray-600');
    });
    // Réinitialiser les valeurs cachées
    document.getElementById('note_objet').value = 0;
    document.getElementById('note_proprietaire').value = 0;
}

// Gestion des étoiles de notation
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.rating-star').forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            const target = this.getAttribute('data-target');
            const container = this.parentElement;
            
            // Mettre à jour les étoiles visuellement
            container.querySelectorAll('.rating-star').forEach((s, index) => {
                if (s.getAttribute('data-target') === target) {
                    if (index < rating) {
                        s.classList.remove('text-gray-300', 'dark:text-gray-600');
                        s.classList.add('text-yellow-400');
                    } else {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-300', 'dark:text-gray-600');
                    }
                }
            });
            
            // Mettre à jour la valeur cachée
            document.getElementById(`note_${target}`).value = rating;
        });
    });
});

// Fonctions pour l'historique d'évaluation
function openEvaluationHistoryModal(evaluation) {
    // Vérifier si evaluation est une string (JSON) et le parser si nécessaire
    if (typeof evaluation === 'string') {
        evaluation = JSON.parse(evaluation);
    }

    // Note objet
    let objetStars = '';
    for (let i = 1; i <= 5; i++) {
        objetStars += `<svg class="w-6 h-6 ${i <= evaluation.note ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'}" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
        </svg>`;
    }
    document.getElementById('historyObjetRatingStars').innerHTML = objetStars;
    
    // Note propriétaire
    let proprietaireStars = '';
    for (let i = 1; i <= 5; i++) {
        proprietaireStars += `<svg class="w-6 h-6 ${i <= evaluation.note ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'}" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
        </svg>`;
    }
    document.getElementById('historyProprietaireRatingStars').innerHTML = proprietaireStars;
    
    // Commentaires
    document.getElementById('historyObjetComment').textContent = evaluation.commentaire || 'Aucun commentaire';
    document.getElementById('historyProprietaireComment').textContent = evaluation.commentaire || 'Aucun commentaire';
    
    // Date
    const date = new Date(evaluation.created_at);
    document.getElementById('evaluationDate').textContent = `Évalué le ${date.toLocaleDateString()} à ${date.toLocaleTimeString()}`;
    
    // Afficher le modal
    document.getElementById('evaluationHistoryModal').classList.remove('hidden');
}

function closeEvaluationHistoryModal() {
    document.getElementById('evaluationHistoryModal').classList.add('hidden');
}

async function submitEvaluationForm(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    const reservationId = formData.get('reservation_id');
    
    submitButton.disabled = true;
    submitButton.innerHTML = 'Envoi en cours...';
    
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            // 1. Fermer le modal
            closeEvaluationFormModal();
            
            // 2. Option 1: Mise à jour immédiate de l'UI (pour réactivité)
            const evaluateBtn = document.querySelector(`button[onclick="openEvaluationFormModal(${reservationId})"]`);
            if (evaluateBtn) {
                const viewBtn = document.createElement('a');
                viewBtn.href = `/client/evaluations/${data.evaluation.id}`;
                viewBtn.className = 'px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition flex items-center';
                viewBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Voir évaluation
                `;
                evaluateBtn.replaceWith(viewBtn);
            }
            
            // 3. Notification
            alert('Évaluation enregistrée avec succès!');
        } else {
            throw new Error(data.message || "Erreur lors de l'envoi");
        }
    } catch (error) {
        alert(error.message);
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = 'Envoyer l\'évaluation';
    }
}

    </script>
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
        background:rgb(55, 31, 31);
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
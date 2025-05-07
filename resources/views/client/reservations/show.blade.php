@extends('client.dashboard')

@section('client-content')
<div class="dashboard-card rounded-xl shadow-lg bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-xl">
    <div class="flex justify-between items-center mb-8">
        <div class="relative overflow-hidden">
            <h2 class="dashboard-card-header text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent animate-pulse">
                <span class="inline-block transform hover:scale-105 transition-transform duration-300">Votre Réservation</span>
            </h2>
            <div class="h-1 w-24 bg-gradient-to-r from-blue-500 to-purple-500 rounded mt-2 transform origin-left scale-x-0 animate-expand"></div>
        </div>
        <div class="flex space-x-2">
            @if($reservation->statut === 'en attente')
                <form action="{{ route('client.reservations.cancel', $reservation->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-red-500 to-red-700 text-white rounded-lg hover:from-red-600 hover:to-red-800 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Annuler la réservation
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
        <!-- Objet details -->
        <div class="dashboard-card bg-gray-50 dark:bg-gray-900 rounded-xl shadow-md p-6 border-l-4 border-blue-500 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
            <div class="relative mb-5">
                <h3 class="text-lg font-semibold dark:text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    <span class="animated-title">Objet loué</span>
                </h3>
                <div class="h-0.5 w-16 bg-blue-500 rounded mt-2 animate-expand"></div>
            </div>
            <div class="flex items-start">
                <img src="{{ $reservation->annonce->objet->images->first()->url ?? '/images/placeholder.png' }}" 
                     alt="{{ $reservation->annonce->objet->nom }}" 
                     class="w-28 h-28 rounded-lg object-cover mr-5 shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <div>
                    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $reservation->annonce->objet->nom }}</h4>
                    <p class="text-gray-600 dark:text-gray-300 mb-3 mt-1 line-clamp-2">{{ $reservation->annonce->objet->description }}</p>
                    <p class="text-gray-600 dark:text-gray-300 flex items-center mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold">Prix journalier:</span> 
                        <span class="ml-1 font-bold text-green-600 dark:text-green-400">{{ number_format($reservation->annonce->objet->prix_journalier, 2) }} MAD</span>
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-semibold">Ville:</span> 
                        <span class="ml-1">{{ $reservation->annonce->objet->ville }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Propriétaire details -->
        <div class="dashboard-card bg-gray-50 dark:bg-gray-900 rounded-xl shadow-md p-6 border-l-4 border-purple-500 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
            <div class="relative mb-5">
                <h3 class="text-lg font-semibold dark:text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="animated-title">Propriétaire</span>
                </h3>
                <div class="h-0.5 w-16 bg-purple-500 rounded mt-2 animate-expand"></div>
            </div>
            <div class="flex items-start">
            <div class="relative">
    @if($reservation->annonce->proprietaire->img_profil)
        <img src="{{ asset($reservation->annonce->proprietaire->img_profil) }}" 
             alt="Photo de {{ $reservation->annonce->proprietaire->prenom }}"
             class="w-28 h-28 rounded-full object-cover mr-5 shadow-md border-2 border-purple-300 dark:border-purple-700 hover:border-purple-500 transition-all duration-300 transform hover:scale-105"
             onerror="this.src='{{ asset('images/IMG1.jpg') }}'">
    @else
        <img src="{{ asset('images/IMG1.jpg') }}" 
             alt="Photo par défaut"
             class="w-28 h-28 rounded-full object-cover mr-5 shadow-md border-2 border-purple-300 dark:border-purple-700 hover:border-purple-500 transition-all duration-300 transform hover:scale-105">
    @endif
    <div class="absolute -bottom-1 -right-1 bg-green-500 w-5 h-5 rounded-full border-2 border-white"></div>
</div>
                <div>
                    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $reservation->annonce->proprietaire->prenom }} {{ $reservation->annonce->proprietaire->nom }}</h4>
                    <p class="text-gray-600 dark:text-gray-300 mb-3 mt-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $reservation->annonce->proprietaire->email }}
                    </p>
                    <div class="flex items-center">
                        <div class="flex mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $ownerAverageRating)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                            <span class="inline-block rounded-full bg-gray-200 dark:bg-gray-700 px-2 py-0.5 mr-1">{{ $ownerAverageRating }}</span>
                            ({{ $ownerRatingsCount }} avis)
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation details -->
    <div class="dashboard-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-lg">
        <div class="relative mb-6">
            <h3 class="text-lg font-semibold dark:text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="animated-title">Détails de la réservation</span>
            </h3>
            <div class="h-0.5 w-36 bg-indigo-500 rounded mt-2 animate-expand"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Date de début</p>
                </div>
                <p class="font-medium text-lg">{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}</p>
            </div>
            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Date de fin</p>
                </div>
                <p class="font-medium text-lg">{{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}</p>
            </div>
            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Durée</p>
                </div>
                <p class="font-medium text-lg">
                    {{ \Carbon\Carbon::parse($reservation->date_debut)->diffInDays($reservation->date_fin) }} jours
                </p>
            </div>
            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Prix journalier</p>
                </div>
                <p class="font-medium text-lg text-green-600 dark:text-green-400">{{ number_format($reservation->annonce->objet->prix_journalier, 2) }} MAD</p>
            </div>
            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Prix total</p>
                </div>
                <p class="font-medium text-lg text-green-600 dark:text-green-400">
                    @php
                        $days = \Carbon\Carbon::parse($reservation->date_debut)->diffInDays($reservation->date_fin);
                        $total = $days * $reservation->annonce->objet->prix_journalier;
                    @endphp
                    {{ number_format($total, 2) }} MAD
                </p>
            </div>
            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Statut</p>
                </div>
                <p class="font-medium">
                    <span class="px-3 py-1.5 text-sm font-medium rounded-full inline-flex items-center
                        {{ $reservation->statut === 'confirmée' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                           ($reservation->statut === 'en attente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                           'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                        @if($reservation->statut === 'confirmée')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        @elseif($reservation->statut === 'en attente')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @endif
                        {{ $reservation->statut }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Ajout des styles CSS pour les animations -->
<style>
    .animated-title {
        position: relative;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .animated-title:hover {
        transform: translateY(-2px);
        color: #4f46e5;
    }
    
    @keyframes expand {
        0% {
            transform: scaleX(0);
        }
        100% {
            transform: scaleX(1);
        }
    }
    
    .animate-expand {
        animation: expand 1.5s ease-out forwards;
    }
    
    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .dashboard-card {
        animation: fadeIn 0.6s ease-out forwards;
    }
</style>
@endsection
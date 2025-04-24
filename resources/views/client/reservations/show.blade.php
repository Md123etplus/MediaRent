@extends('client.dashboard')

@section('client-content')
<div class="dashboard-card">
    <div class="flex justify-between items-center mb-6">
        <h2 class="dashboard-card-header">Détails de la réservation</h2>
        <div class="flex space-x-2">
            @if($reservation->statut === 'en attente')
                <form action="{{ route('client.reservations.cancel', $reservation->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Annuler la réservation
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Objet details -->
        <div class="dashboard-card">
            <h3 class="text-lg font-semibold mb-4 dark:text-white">Objet loué</h3>
            <div class="flex items-start">
                <img src="{{ $reservation->annonce->objet->images->first()->url ?? '/images/placeholder.png' }}" 
                     alt="{{ $reservation->annonce->objet->nom }}" 
                     class="w-24 h-24 rounded-lg object-cover mr-4">
                <div>
                    <h4 class="text-xl font-bold">{{ $reservation->annonce->objet->nom }}</h4>
                    <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $reservation->annonce->objet->description }}</p>
                    <p class="text-gray-600 dark:text-gray-300">
                        <span class="font-semibold">Prix journalier:</span> 
                        {{ number_format($reservation->annonce->objet->prix_journalier, 2) }} €
                    </p>
                    <p class="text-gray-600 dark:text-gray-300">
                        <span class="font-semibold">Ville:</span> {{ $reservation->annonce->objet->ville }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Propriétaire details -->
        <div class="dashboard-card">
            <h3 class="text-lg font-semibold mb-4 dark:text-white">Propriétaire</h3>
            <div class="flex items-start">
                <img src="{{ $reservation->annonce->proprietaire->img_profil ?? '/images/default-profile.png' }}" 
                     alt="{{ $reservation->annonce->proprietaire->prenom }}" 
                     class="w-24 h-24 rounded-full object-cover mr-4">
                <div>
                    <h4 class="text-xl font-bold">{{ $reservation->annonce->proprietaire->prenom }} {{ $reservation->annonce->proprietaire->nom }}</h4>
                    <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $reservation->annonce->proprietaire->email }}</p>
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
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            ({{ $ownerRatingsCount }} avis)
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation details -->
    <div class="dashboard-card mb-8">
        <h3 class="text-lg font-semibold mb-4 dark:text-white">Détails de la réservation</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Date de début</p>
                <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Date de fin</p>
                <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Durée</p>
                <p class="font-medium">
                    {{ \Carbon\Carbon::parse($reservation->date_debut)->diffInDays($reservation->date_fin) }} jours
                </p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Prix journalier</p>
                <p class="font-medium">{{ number_format($reservation->annonce->objet->prix_journalier, 2) }} €</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Prix total</p>
                <p class="font-medium">
                    @php
                        $days = \Carbon\Carbon::parse($reservation->date_debut)->diffInDays($reservation->date_fin);
                        $total = $days * $reservation->annonce->objet->prix_journalier;
                    @endphp
                    {{ number_format($total, 2) }} €
                </p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Statut</p>
                <p class="font-medium">
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $reservation->statut === 'confirmée' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                           ($reservation->statut === 'en attente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                           'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                        {{ $reservation->statut }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Evaluation section -->
    @if($reservation->statut === 'terminée')
        <div class="dashboard-card">
            <h3 class="text-lg font-semibold mb-4 dark:text-white">Évaluation</h3>
            @if($reservation->evaluation)
                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium mb-2">Note pour l'objet</h4>
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $reservation->evaluation->note_objet)
                                    <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $reservation->evaluation->commentaire_objet }}</p>
                    </div>
                    <div>
                        <h4 class="font-medium mb-2">Note pour le propriétaire</h4>
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $reservation->evaluation->note_proprietaire)
                                    <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $reservation->evaluation->commentaire_proprietaire }}</p>
                    </div>
                </div>
            @else
                <p class="mb-4">Vous n'avez pas encore évalué cette réservation.</p>
                <a href="{{ route('client.evaluations.create', $reservation->id) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Ajouter une évaluation
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
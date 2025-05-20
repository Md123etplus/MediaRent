@extends('client.dashboard')

@section('client-content')
<div class="dashboard-card p-6 space-y-6">
    <!-- Titre animé avec gradient -->
    <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 animate-text">
        🚚 Suivi des Livraisons
    </h2>

    @if($livraisons->count() > 0)
        <div class="grid gap-8 animate-fade-in">
            @foreach($livraisons as $reservation)
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-xl transform transition duration-500 hover:scale-[1.02] hover:rotate-1 hover:shadow-[0_10px_25px_-5px_rgba(100,100,255,0.4),0_5px_10px_-5px_rgba(255,100,255,0.3)]">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <!-- Emoji animé -->
                            <div class="text-5xl animate-bounce animate-pulse">🚚</div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition duration-300">
                                    {{ $reservation->annonce->objet->nom }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                                    📍 {{ $reservation->adresse_livraison }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <!-- Badge animé avec statut -->
                            <span class="px-4 py-2 rounded-full text-sm font-bold tracking-wide shadow-md transition-all duration-300 animate-pulse
                                {{ 
                                    $reservation->statut_livraison === 'en_attente' 
                                        ? 'bg-yellow-200 text-yellow-900 dark:bg-yellow-900 dark:text-yellow-200' 
                                        : ($reservation->statut_livraison === 'en_cours' 
                                            ? 'bg-blue-200 text-blue-900 dark:bg-blue-900 dark:text-blue-200' 
                                            : 'bg-green-200 text-green-900 dark:bg-green-900 dark:text-green-200') 
                                }}">
                                {{ ucfirst($reservation->statut_livraison) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 animate-fade-in-slow">
            <p class="text-gray-600 dark:text-gray-300 text-lg">
                😕 Aucune livraison en cours pour le moment.
            </p>
        </div>
    @endif
</div>
@endsection

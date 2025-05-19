@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Sidebar -->
        <div class="w-64 sidebar">
            <div class="p-4 flex items-center space-x-4 glass-card">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">{{ Auth::user()?->prenom ?? 'Test Guest' }}</h2>
                    <p class="text-xs text-indigo-500 font-medium">Partenaire MediaRent</p>
                </div>
            </div>

            <nav class="mt-6">
                <!-- Existing sidebar navigation code -->
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-x-hidden">
            <div class="container mx-auto px-4 py-8">
                <h1
                    class="text-3xl font-bold mb-8 text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 animate-gradient">
                    Gestion des Livraisons
                </h1>

                @if ($livraisons->count() > 0)
                    <div class="grid gap-6">
                        @foreach ($livraisons as $reservation)
                            <div
                                class="bg-white rounded-xl shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-[1.02] border border-gray-100 hover:border-purple-200 overflow-hidden backdrop-blur-sm">
                                <div class="p-6 relative">
                                    <!-- Effet de brillance au hover -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 hover:opacity-20 transform translate-x-[-100%] hover:translate-x-[100%] transition-all duration-1000">
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <!-- Informations de la réservation -->
                                        <div class="flex items-start space-x-6">
                                            <div class="flex-shrink-0 relative group">
                                                <img src="{{ asset('images/objet_' . $reservation->annonce->objet->id . '.jpg') }}"
                                                    alt="{{ $reservation->annonce->objet->nom }}"
                                                    class="h-24 w-24 rounded-xl object-cover transition-transform duration-300 group-hover:scale-110 shadow-md">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl">
                                                </div>
                                            </div>

                                            <div class="space-y-3">
                                                <h3
                                                    class="text-xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors duration-300">
                                                    {{ $reservation->annonce->objet->nom }}
                                                </h3>
                                                <div class="space-y-2">
                                                    <p class="flex items-center text-gray-600 text-sm">
                                                        <span
                                                            class="inline-block w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-3">
                                                            <i class="fas fa-user"></i>
                                                        </span>
                                                        {{ $reservation->client->prenom }} {{ $reservation->client->nom }}
                                                    </p>
                                                    <p class="flex items-center text-gray-600 text-sm">
                                                        <span
                                                            class="inline-block w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mr-3">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </span>
                                                        {{ $reservation->adresse_livraison }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-col items-end space-y-4">
                                            <span
                                                class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 
                                            {{ $reservation->statut_livraison === 'en_attente'
                                                ? 'bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 hover:from-yellow-200 hover:to-amber-200'
                                                : ($reservation->statut_livraison === 'en_cours'
                                                    ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 hover:from-blue-200 hover:to-indigo-200'
                                                    : 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 hover:from-green-200 hover:to-emerald-200') }}">
                                                {{ ucfirst($reservation->statut_livraison) }}
                                            </span>

                                            <!-- Boutons d'action -->
                                            <div class="flex space-x-3">
                                                @if ($reservation->statut_livraison === 'en_attente')
                                                    <button onclick="repondreLivraison({{ $reservation->id }}, 'accepter')"
                                                        class="px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg 
                                                               hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 
                                                               transition-all duration-300 shadow-md hover:shadow-xl 
                                                               focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <i class="fas fa-check mr-2"></i>Accepter
                                                    </button>
                                                    <button onclick="repondreLivraison({{ $reservation->id }}, 'refuser')"
                                                        class="px-6 py-2 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-lg 
                                                               hover:from-red-600 hover:to-pink-700 transform hover:scale-105 
                                                               transition-all duration-300 shadow-md hover:shadow-xl 
                                                               focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        <i class="fas fa-times mr-2"></i>Refuser
                                                    </button>
                                                @endif

                                                @if ($reservation->statut_livraison === 'en_cours')
                                                    <button onclick="repondreLivraison({{ $reservation->id }}, 'livre')"
                                                        class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg 
                                                               hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 
                                                               transition-all duration-300 shadow-md hover:shadow-xl 
                                                               focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        <i class="fas fa-truck mr-2"></i>Marquer comme livré
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-lg shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune livraison en attente</h3>
                        <p class="mt-1 text-sm text-gray-500">Les demandes de livraison de vos clients apparaîtront ici.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 6s ease infinite;
        }

        /* Ajout d'un effet de pulse subtil sur les boutons */
        @keyframes pulse-border {
            0% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
            }
        }

        button {
            animation: pulse-border 2s infinite;
        }
    </style>

    <script>
        async function repondreLivraison(reservationId, reponse) {
            try {
                const response = await fetch(`/partenaire/livraisons/${reservationId}/repondre/${reponse}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Actualiser la page pour montrer les changements
                    window.location.reload();
                } else {
                    alert('Erreur lors de la mise à jour du statut: ' + data.message);
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la mise à jour du statut');
            }
        }
    </script>
@endsection

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
                // ...existing sidebar navigation code...
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-x-hidden">
            <div class="container mx-auto px-4 py-8">
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Détails de la Livraison</h1>
                    <a href="{{ route('partenaire.livraisons') }}"
                        class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Retour
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations de la commande -->
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold text-gray-800">Informations de la commande</h2>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Numéro de commande</p>
                                        <p class="font-medium">#{{ $reservation->id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Statut</p>
                                        <span
                                            class="px-2 py-1 rounded-full text-sm font-medium 
                                        {{ $reservation->statut_livraison === 'en_attente'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($reservation->statut_livraison === 'en_cours'
                                                ? 'bg-blue-100 text-blue-800'
                                                : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($reservation->statut_livraison) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Date de début</p>
                                        <p class="font-medium">{{ $reservation->date_debut->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Date de fin</p>
                                        <p class="font-medium">{{ $reservation->date_fin->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations du client -->
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold text-gray-800">Informations du client</h2>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="font-medium">{{ $reservation->client->prenom }} {{ $reservation->client->nom }}
                                </p>
                                <p class="text-gray-600">{{ $reservation->client->email }}</p>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">Adresse de livraison</p>
                                    <p class="mt-1">{{ $reservation->adresse_livraison }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

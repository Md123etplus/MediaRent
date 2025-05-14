@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- En-tête du profil -->
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="h-24 w-24 rounded-full bg-white flex items-center justify-center text-3xl font-bold text-purple-600">
                            {{ strtoupper(substr($partenaire->prenom, 0, 1)) }}{{ strtoupper(substr($partenaire->nom, 0, 1)) }}
                        </div>
                    </div>
                    <div class="ml-6">
                        <h1 class="text-2xl font-bold text-white">
                            {{ $partenaire->prenom }} {{ $partenaire->nom }}
                        </h1>
                        <p class="text-purple-200">Membre depuis {{ $partenaire->created_at->format('M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-xl font-bold text-purple-600">{{ $stats['nombre_objets'] }}</div>
                    <div class="text-gray-600">Objets proposés</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-xl font-bold text-purple-600">{{ number_format($stats['note_moyenne'], 1) }}/5</div>
                    <div class="text-gray-600">Note moyenne</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-xl font-bold text-purple-600">{{ $stats['nombre_locations'] }}</div>
                    <div class="text-gray-600">Locations réalisées</div>
                </div>
            </div>

            <!-- Liste des objets -->
            @if ($objets->count() > 0)
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Objets proposés</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($objets as $objet)
                            <div
                                class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                                <img src="{{ asset($objet->image_url ?? 'images/default.jpg') }}"
                                    alt="Photo de {{ $objet->nom }}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900">{{ $objet->nom }}</h3>
                                    <p class="text-gray-600">{{ $objet->ville }}</p>
                                    <div class="mt-2 text-purple-600 font-bold">
                                        {{ number_format($objet->prix_journalier, 2) }} €/jour
                                    </div>
                                    <a href="{{ route('fiches.objet.show', $objet->id) }}"
                                        class="mt-2 inline-block text-sm text-purple-600 hover:text-purple-700">
                                        Voir les détails →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="p-6 text-center text-gray-500">
                    Aucun objet proposé pour le moment
                </div>
            @endif
        </div>
    </div>
@endsection

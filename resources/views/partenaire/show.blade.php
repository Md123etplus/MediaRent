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

            <!-- Section des commentaires -->
            <div class="p-6 border-t border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-2xl mr-2">💬</span> 
                    Avis des clients
                </h2>

                <div class="space-y-6">
                    @foreach($partenaire->evaluationsRecues as $evaluation)
                        <div class="bg-gray-50 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <!-- En-tête avec infos client et note -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($evaluation->evaluateur->prenom, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $evaluation->evaluateur->prenom }} {{ substr($evaluation->evaluateur->nom, 0, 1) }}.
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($evaluation->date)->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center bg-white px-3 py-1 rounded-full shadow-sm">
                                    <span class="text-yellow-400 font-bold mr-1">{{ $evaluation->note_proprietaire }}</span>
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $evaluation->note_proprietaire ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <!-- Commentaire -->
                            <p class="text-gray-700">{{ $evaluation->commentaire_proprietaire }}</p>

                            <!-- Objet loué -->
                            <div class="mt-4 flex items-center text-sm text-purple-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <a href="{{ route('fiches.objet.show', $evaluation->reservationAssociee->annonce->objet->id) }}" 
                                   class="hover:text-purple-800">
                                    Location : {{ $evaluation->reservationAssociee->annonce->objet->nom }}
                                </a>
                            </div>
                        </div>
                    @endforeach

                    @if($partenaire->evaluationsRecues->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <span class="text-4xl mb-4 block">💭</span>
                            <p class="text-gray-500">Aucun avis pour le moment</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

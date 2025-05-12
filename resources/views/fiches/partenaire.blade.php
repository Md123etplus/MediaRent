@extends('layouts.app')

@section('title', 'Fiche Partenaire: ' . $partenaire->surnom)

@section('content')
<div class="fiche-container max-w-5xl mx-auto p-8 bg-gradient-to-br from-gray-50 to-cyan-50 rounded-3xl shadow-2xl shadow-cyan-200/50 hover:shadow-cyan-300/70 transition-all duration-500 transform hover:-translate-y-1">
    <header class="fiche-header mb-10 p-8 bg-gradient-to-r from-cyan-500 via-blue-500 to-indigo-600 rounded-2xl shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==')]"></div>
        <div class="flex items-center relative z-10">
            <img src="{{ $partenaire->img_profil ?: 'https://via.placeholder.com/100.png?text=Profil' }}" 
                 alt="Profil de {{ $partenaire->surnom }}" 
                 class="w-28 h-28 rounded-full mr-6 shadow-xl border-4 border-white/90 hover:border-cyan-200 hover:scale-105 transition-all duration-300">
            <div>
                <h1 class="text-4xl font-extrabold text-white drop-shadow-md">{{ $partenaire->surnom }}</h1>
                <div class="inline-block mt-2 px-4 py-1 bg-white/20 backdrop-blur-sm rounded-full border border-white/30">
                    <p class="text-white/90 font-semibold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                        </svg>
                        Partenaire Premium
                    </p>
                </div>
            </div>
        </div>
    </header>

    <div class="fiche-section bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-cyan-500 mb-10">
        <h2 class="text-3xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 to-blue-600">
            <span class="inline-block mr-2">📊</span> Statistiques & Performances
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Note moyenne -->
            <div class="stats-card group p-5 bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl border border-cyan-100 hover:border-cyan-300 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center">
                    <div class="w-14 h-14 rounded-full bg-cyan-100 flex items-center justify-center mr-4 group-hover:bg-cyan-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-cyan-600" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-600 group-hover:text-cyan-800 transition-colors">Note moyenne</span>
                        <span class="text-2xl font-extrabold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">
                            {{ number_format($partenaire->note_moyenne_partenaire, 1) ?? 'N/A' }}<span class="text-gray-400">/5</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Nombre d'avis -->
            <div class="stats-card group p-5 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100 hover:border-blue-300 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-600 group-hover:text-blue-800 transition-colors">Avis reçus</span>
                        <span class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            {{ $partenaire->nombre_avis_partenaire }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Annonces publiées -->
            <div class="stats-card group p-5 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl border border-indigo-100 hover:border-indigo-300 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center">
                    <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center mr-4 group-hover:bg-indigo-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-600 group-hover:text-indigo-800 transition-colors">Annonces publiées</span>
                        <span class="text-2xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            {{ $partenaire->nombre_annonces_publiees }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Locations réalisées -->
            <div class="stats-card group p-5 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border border-purple-100 hover:border-purple-300 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center">
                    <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mr-4 group-hover:bg-purple-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1V5a1 1 0 00-1-1H3z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-600 group-hover:text-purple-800 transition-colors">Locations réalisées</span>
                        <span class="text-2xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            {{ $partenaire->nombre_locations_realisees_partenaire }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fiche-section bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-pink-500">
        <h2 class="text-3xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-rose-600">
            <span class="inline-block mr-2">🛍️</span> Inventaire du Partenaire
        </h2>
        
        @if($partenaire->objets_en_ligne->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($partenaire->objets_en_ligne as $objet)
                    <div class="object-card group relative bg-white rounded-xl border border-gray-200 hover:border-pink-300 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $objet->premiere_image_url }}" alt="{{$objet->nom}}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            <span class="absolute top-3 right-3 bg-pink-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                {{ number_format($objet->prix_journalier, 2, ',', ' ') }} €/jour
                            </span>
                        </div>
                        <div class="p-5">
                            <a href="{{ route('fiches.objet.show', $objet->id) }}" 
                               class="text-lg font-bold text-gray-800 hover:text-pink-600 transition-colors block mb-1">
                                {{ $objet->nom }}
                            </a>
                            <span class="inline-block px-2 py-1 bg-cyan-100 text-cyan-800 text-xs font-medium rounded-full mb-3">
                                {{ $objet->categorie->nom ?? 'Non catégorisé' }}
                            </span>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                Localisation
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-700 mb-2">Aucun objet en ligne</h3>
                <p class="text-gray-500 max-w-md mx-auto">Ce partenaire n'a actuellement aucun objet disponible à la location.</p>
            </div>
        @endif
    </div>

    {{-- Section pour les commentaires --}}
    @if(false) {{-- Condition à adapter --}}
    <div class="mt-10 bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-rose-400">
        <h2 class="text-3xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-rose-600 to-red-600">
            <span class="inline-block mr-2">💬</span> Témoignages Clients
        </h2>
        {{-- Ici les commentaires --}}
    </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('title', 'Fiche Objet: ' . $objet->nom)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header avec effet néon -->
    <header class="fiche-header mb-10 p-8 bg-gradient-to-r from-indigo-900 to-purple-900 rounded-3xl shadow-2xl relative overflow-hidden">
        <!-- Effet de particules animées -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-1/4 left-1/4 w-48 h-48 rounded-full bg-pink-500 mix-blend-overlay filter blur-3xl opacity-70 animate-pulse"></div>
            <div class="absolute bottom-1/3 right-1/3 w-56 h-56 rounded-full bg-cyan-500 mix-blend-overlay filter blur-3xl opacity-50 animate-pulse delay-300"></div>
        </div>
        
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-3 drop-shadow-lg neon-text">{{ $objet->nom }}</h1>
            <p class="text-white/90 flex items-center text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-cyan-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                Proposé par:
                @if($objet->proprietaire)
                    <a href="{{ route('partenaire.show', $objet->proprietaire->id) }}" 
                       class="ml-2 font-bold text-cyan-300 hover:text-white transition-colors duration-300 flex items-center group">
                        {{ $objet->proprietaire->nom }} {{ $objet->proprietaire->prenom }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <span class="ml-2 italic text-gray-300">Information non disponible</span>
                @endif
            </p>
        </div>
    </header>

    <!-- Galerie d'images avec effet lightbox -->
    @if($objet->images && $objet->images->count() > 0)
        <div class="mb-12">
            <h2 class="text-3xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">
                <span class="inline-block mr-2">📸</span> Galerie Photos
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($objet->images as $image)
                    <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <img src="{{ asset($image->url) }}" 
                             alt="Photo de {{ $objet->nom }}" 
                             class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <span class="text-white font-medium">Voir en grand</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="mb-12 text-center py-12 bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl border-2 border-dashed border-gray-300">
            <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-medium text-gray-700 mb-2">Aucune photo disponible</h3>
            <p class="text-gray-500 max-w-md mx-auto">Cet objet ne contient pas encore d'images</p>
        </div>
    @endif

    <!-- Grid d'informations -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Colonne Principale -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Carte Catégorie -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-2xl border border-gray-200 hover:border-indigo-300 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-start">
                    <div class="bg-indigo-100 p-3 rounded-xl mr-4 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Catégorie</h3>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $objet->categorie->nom ?? 'Non spécifiée' }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte Prix -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-2xl border border-gray-200 hover:border-green-300 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-start">
                    <div class="bg-green-100 p-3 rounded-xl mr-4 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Prix journalier</h3>
                        <p class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-emerald-600 mt-1">
                            {{ number_format($objet->prix_journalier, 2, ',', ' ') }} €
                        </p>
                        <p class="text-sm text-gray-500 mt-1">TVA incluse</p>
                    </div>
                </div>
            </div>

            <!-- Carte Localisation -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-2xl border border-gray-200 hover:border-cyan-300 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-start">
                    <div class="bg-cyan-100 p-3 rounded-xl mr-4 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Localisation</h3>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $objet->ville }}</p>
                        <p class="text-sm text-gray-500 mt-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Livraison possible: {{ $objet->option_livraison_texte }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne Secondaire - Avis -->
        <div class="space-y-6">
            <!-- Carte Évaluations -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-2xl border border-gray-200 hover:border-yellow-300 shadow-lg hover:shadow-xl transition-all duration-300 h-full">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Évaluations
                </h3>

                @if($objet->nombre_avis_objet > 0)
                    <div class="flex items-center mb-4">
                        <div class="text-5xl font-bold text-yellow-500 mr-4">
                            {{ number_format($objet->note_moyenne_objet, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($objet->note_moyenne_objet))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-sm text-gray-600">{{ $objet->nombre_avis_objet }} avis</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button class="w-full py-2 px-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white font-medium rounded-lg shadow hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                            Voir tous les avis
                        </button>
                    </div>
                @else
                    <div class="text-center py-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500">Aucun avis pour cet objet</p>
                        <button class="mt-4 py-2 px-4 bg-gray-100 text-gray-700 font-medium rounded-lg shadow-sm hover:bg-gray-200 transition-colors duration-300">
                            Soyez le premier à évaluer
                        </button>
                    </div>
                @endif
            </div>

            <!-- Carte Statistiques -->
            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-2xl border border-gray-200 hover:border-blue-300 shadow-lg hover:shadow-xl transition-all duration-300">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Statistiques
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Locations effectuées</span>
                        <span class="font-bold text-blue-600">{{ $objet->nombre_locations }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Disponibilité</span>
                        <span class="font-bold {{ $objet->periodes_disponibilite->count() > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $objet->periodes_disponibilite->count() > 0 ? 'Disponible' : 'Indisponible' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">État</span>
                        <span class="font-bold 
                            @if($objet->etat === 'excellent') text-green-600
                            @elseif($objet->etat === 'bon') text-blue-600
                            @elseif($objet->etat === 'moyen') text-yellow-600
                            @else text-gray-600
                            @endif">
                            {{ ucfirst($objet->etat) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Description -->
    <div class="fiche-section mb-12 bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl border border-gray-200 hover:border-purple-300 shadow-lg hover:shadow-xl transition-all duration-300">
        <h2 class="text-3xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-500">
            <span class="inline-block mr-2">📝</span> Description
        </h2>
        <div class="prose max-w-none text-gray-700">
            <p class="text-lg leading-relaxed">{{ $objet->description }}</p>
        </div>
    </div>

    <!-- Section Disponibilités -->
    <div class="fiche-section mb-12 bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl border border-gray-200 hover:border-cyan-300 shadow-lg hover:shadow-xl transition-all duration-300">
        <h2 class="text-3xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 to-blue-500">
            <span class="inline-block mr-2">📅</span> Disponibilités
        </h2>
        
        @if($objet->periodes_disponibilite && $objet->periodes_disponibilite->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($objet->periodes_disponibilite as $periode)
                    <div class="bg-white p-4 rounded-lg border border-gray-200 hover:border-green-300 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Du {{ $periode['debut'] }}</p>
                                <p class="text-sm text-gray-600">au {{ $periode['fin'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-medium text-gray-700 mb-2">Aucune disponibilité actuelle</h3>
                <p class="text-gray-500">Cet objet n'a pas de périodes de disponibilité annoncées pour le moment.</p>
            </div>
        @endif
    </div>

    <!-- Bouton d'action principal -->
    <div class="text-center mb-12">
        <button class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-full shadow-xl hover:shadow-2xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:-translate-y-1 text-lg">
            Réserver cet objet
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline ml-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>

<!-- Style personnalisé pour l'effet néon -->
<style>
    .neon-text {
        text-shadow: 0 0 5px rgba(99, 102, 241, 0.5), 
                     0 0 10px rgba(99, 102, 241, 0.4), 
                     0 0 15px rgba(99, 102, 241, 0.3);
        animation: neon-glow 1.5s ease-in-out infinite alternate;
    }
    
    @keyframes neon-glow {
        from {
            text-shadow: 0 0 5px rgba(99, 102, 241, 0.5), 
                         0 0 10px rgba(99, 102, 241, 0.4), 
                         0 0 15px rgba(99, 102, 241, 0.3);
        }
        to {
            text-shadow: 0 0 10px rgba(99, 102, 241, 0.7), 
                         0 0 20px rgba(99, 102, 241, 0.6), 
                         0 0 30px rgba(99, 102, 241, 0.5);
        }
    }
</style>
@endsection
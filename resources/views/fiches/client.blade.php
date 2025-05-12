@extends('layouts.app')

@section('title', 'Fiche Client: ' . $client->surnom)

@section('content')
<div class="fiche-container max-w-4xl mx-auto p-6 bg-gradient-to-br from-gray-50 to-purple-50 rounded-3xl shadow-2xl shadow-purple-200/50 hover:shadow-purple-300/70 transition-all duration-500 transform hover:-translate-y-1">
     <header class="fiche-header mb-8 p-6 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl shadow-lg">
        <div class="flex items-center">
            <img src="{{ $client->img_profil ?: 'https://via.placeholder.com/100.png?text=Profil' }}" 
                 alt="Profil de {{ $client->surnom }}" 
                 class="w-24 h-24 rounded-full mr-4 shadow-xl border-4 border-white/80 hover:border-pink-200 hover:scale-105 transition-all duration-300">
            <div>
                <h1 class="text-3xl font-bold text-white drop-shadow-md">{{ $client->surnom }}</h1>
                <p class="text-white/90 font-medium">Client Premium</p>
            </div>
        </div>
    </header>

    <div class="fiche-section bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-indigo-400">
        <h2 class="text-2xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">
            Informations & Évaluations
        </h2>
        
        <div class="space-y-4">
            <div class="info-item group flex items-center p-4 rounded-lg hover:bg-indigo-50/80 transition-colors duration-200">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-4 group-hover:bg-indigo-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <div>
                    <span class="font-semibold text-gray-600 group-hover:text-indigo-700 transition-colors">Note moyenne:</span>
                    <span class="ml-2 font-bold text-xl bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        {{ number_format($client->note_moyenne_client, 1) ?? 'N/A' }} / 5
                    </span>
                </div>
            </div>
            
            <div class="info-item group flex items-center p-4 rounded-lg hover:bg-indigo-50/80 transition-colors duration-200">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-4 group-hover:bg-indigo-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <span class="font-semibold text-gray-600 group-hover:text-indigo-700 transition-colors">Nombre d'avis reçus:</span>
                    <span class="ml-2 font-bold text-xl bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        {{ $client->nombre_avis_client }}
                    </span>
                </div>
            </div>
            
            <div class="info-item group flex items-center p-4 rounded-lg hover:bg-indigo-50/80 transition-colors duration-200">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-4 group-hover:bg-indigo-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1V5a1 1 0 00-1-1H3z" />
                    </svg>
                </div>
                <div>
                    <span class="font-semibold text-gray-600 group-hover:text-indigo-700 transition-colors">Nombre de locations:</span>
                    <span class="ml-2 font-bold text-xl bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        {{ $client->nombre_locations_effectuees_client }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Section pour les commentaires --}}
    @if(false) {{-- Condition à adapter --}}
    <div class="mt-10 bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-pink-400">
        <h2 class="text-2xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-rose-600">
            Commentaires des partenaires
        </h2>
        {{-- Ici les commentaires --}}
    </div>
    @endif
</div>
@endsection
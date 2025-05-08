@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-cyan-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header with gradient text -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-600 to-blue-600">
                Fiche Objet
            </h1>
            <h2 class="text-3xl font-extrabold text-gray-900">{{ $objet->nom }}</h2>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transition-all duration-500 hover:shadow-3xl">
            <!-- Image Gallery Section -->
            <div class="relative h-96 overflow-hidden">
                <img src="{{ $objet->main_image_url }}" 
                     alt="Photo de {{ $objet->nom }}" 
                     class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                <!-- Floating price tag -->
                <div class="absolute top-6 right-6 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-3 rounded-full shadow-lg font-bold text-xl">
                    {{ number_format($objet->prix_journalier, 2, ',', ' ') }} €<span class="text-sm font-normal">/jour</span>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-8 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Left Column -->
                    <div class="md:col-span-2">
                        <!-- Owner Info -->
                        <div class="flex items-center mb-8">
                            <div class="mr-4">
                                <span class="text-sm font-medium text-gray-500">Propriétaire</span>
                                <a href="{{ route('fiches.partenaire.show', $objet->proprietaire) }}" 
                                   class="flex items-center group">
                                    
                                    <span class="text-xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors">
                                        {{ $objet->proprietaire->surnom }}
                                    </span>
                                </a>
                            </div>
                            <!-- Rating -->
                            <div class="ml-auto">
                                @if($objet->average_rating !== null)
                                <div class="flex items-center">
                                    <div class="flex mr-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $objet->average_rating)
                                                <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-lg font-bold text-gray-700">
                                        {{ number_format($objet->average_rating, 1) }}/5
                                    </span>
                                </div>
                                @else
                                <span class="text-gray-500 italic">Pas encore de notes</span>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 border-b-2 border-purple-100 pb-2">Description</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $objet->description }}</p>
                        </div>

                        <!-- Availability -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 border-b-2 border-purple-100 pb-2">Disponibilité</h3>
                            @if($objet->is_available)
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-green-100 to-green-200 text-green-800">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Disponible via annonces actives
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Vérifier les annonces
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column - Details -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-purple-100 pb-2">Détails</h3>
                        
                        <div class="space-y-4">
                            <!-- Category -->
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Catégorie</span>
                                <span class="text-lg font-semibold text-gray-800">
                                    {{ $objet->categorie->nom ?? 'Non catégorisé' }}
                                </span>
                            </div>
                            
                            <!-- City -->
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Ville</span>
                                <span class="text-lg font-semibold text-gray-800">{{ $objet->ville }}</span>
                            </div>
                            
                            <!-- Condition -->
                            <div>
                                <span class="block text-sm font-medium text-gray-500">État</span>
                                <span class="text-lg font-semibold text-gray-800">{{ ucfirst($objet->etat) }}</span>
                            </div>
                            
                            <!-- Active Announcements -->
                            <div class="pt-4 border-t border-gray-200">
                                <span class="block text-sm font-medium text-gray-500 mb-2">Annonces actives</span>
                                @if($objet->annonces->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($objet->annonces as $annonce)
                                        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <div class="font-medium text-gray-800">
                                                        Du {{ \Carbon\Carbon::parse($annonce->date_debut)->format('d/m/Y') }} 
                                                        au {{ \Carbon\Carbon::parse($annonce->date_fin)->format('d/m/Y') }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Statut: 
                                                        <span class="font-medium {{ $annonce->statut === 'disponible' ? 'text-green-600' : 'text-amber-600' }}">
                                                            {{ $annonce->statut }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <button class="px-3 py-1 bg-gradient-to-r from-purple-500 to-blue-500 text-white text-sm rounded-full hover:opacity-90 transition-opacity">
                                                    Réserver
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 italic">Aucune annonce active actuellement</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-10 text-center">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-full shadow-sm text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 transition-all duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </a>
        </div>
    </div>
</div>
@endsection
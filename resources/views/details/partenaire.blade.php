@extends('layouts.app') {{-- Adaptez à votre layout principal --}}

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
                Fiche Partenaire
            </h1>
            <div class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium animate-pulse">
                {{ $partenaire->surnom }}
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <div class="md:flex">
                <!-- Profile Image Section -->
                <div class="md:w-1/3 bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center p-8">
                    <div class="relative">
                        <div class="w-40 h-40 rounded-full bg-gradient-to-r from-purple-400 to-indigo-500 flex items-center justify-center text-white text-5xl font-bold shadow-lg">
                            {{ substr($partenaire->prenom, 0, 1) }}{{ substr($partenaire->nom, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-2 shadow-md">
                            <div class="bg-gradient-to-r from-amber-400 to-amber-500 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Info Section -->
                <div class="md:w-2/3 p-8">
                    <div class="uppercase tracking-wide text-sm text-indigo-600 font-semibold mb-1">Détails du partenaire</div>
                    
                    <div class="space-y-6">
                        <!-- Nickname -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Surnom</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $partenaire->surnom }}</p>
                        </div>
                        
                        <!-- Full Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nom complet</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $partenaire->prenom }} {{ $partenaire->nom }}
                            </p>
                        </div>
                        
                        <!-- Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Note moyenne</label>
                            @if($partenaire->average_rating !== null)
                            <div class="flex items-center mt-2">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($partenaire->average_rating))
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @elseif($i - 0.5 <= $partenaire->average_rating)
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half-star" x1="0" x2="100%" y1="0" y2="0">
                                                        <stop offset="50%" stop-color="currentColor"></stop>
                                                        <stop offset="50%" stop-color="#d1d5db"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-gray-600 font-medium">
                                    {{ number_format($partenaire->average_rating, 1) }} / 5
                                </span>
                            </div>
                            @else
                            <p class="mt-1 text-gray-500 italic">Pas encore de notes</p>
                            @endif
                        </div>
                        
                        <!-- Ads Count -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nombre d'annonces publiées</label>
                            <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                {{ $partenaire->nombre_annonces }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </a>
        </div>
    </div>
</div>
@endsection
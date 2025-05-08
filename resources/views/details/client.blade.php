@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header with gradient -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 mb-4">
                Fiche Client
            </h1>
            <div class="inline-block px-6 py-2 bg-gradient-to-r from-purple-100 to-indigo-100 rounded-full shadow-md">
                <span class="text-2xl font-bold text-gray-800">{{ $client->surnom }}</span>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <div class="md:flex">
                <!-- Left Side - Avatar Placeholder -->
                <div class="md:w-1/3 bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center p-8">
                    <div class="relative">
                        <div class="w-40 h-40 rounded-full bg-gradient-to-r from-purple-400 to-indigo-500 flex items-center justify-center text-white text-5xl font-bold shadow-lg">
                            {{ substr($client->prenom, 0, 1) }}{{ substr($client->nom, 0, 1) }}
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

                <!-- Right Side - Profile Info -->
                <div class="md:w-2/3 p-8">
                    <div class="space-y-6">
                        <!-- Nickname -->
                        <div>
                            <div class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Surnom</div>
                            <div class="mt-1 text-2xl font-bold text-gray-900">{{ $client->surnom }}</div>
                        </div>

                        <!-- Full Name -->
                        <div>
                            <div class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Nom complet</div>
                            <div class="mt-1 text-xl font-semibold text-gray-800">
                                {{ $client->prenom }} {{ $client->nom }}
                            </div>
                        </div>

                        <!-- Rating -->
                        <div>
                            <div class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Note moyenne</div>
                            <div class="mt-2 flex items-center">
                                @if($client->average_rating !== null)
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($client->average_rating))
                                            <svg class="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @elseif($i - 0.5 <= $client->average_rating)
                                            <svg class="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half-star" x1="0" x2="100%" y1="0" y2="0">
                                                        <stop offset="50%" stop-color="currentColor"></stop>
                                                        <stop offset="50%" stop-color="#d1d5db"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-lg font-bold text-gray-700">
                                    {{ number_format($client->average_rating, 1) }} / 5
                                </span>
                                @else
                                <span class="text-gray-500 italic">Pas encore de notes</span>
                                @endif
                            </div>
                        </div>

                        <!-- Rentals Count -->
                        <div>
                            <div class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Locations</div>
                            <div class="mt-2 inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-green-100 to-green-200 text-green-800 font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                {{ $client->nombre_locations }} location(s)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-10 text-center">
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-full shadow-sm text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 transition-all duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </a>
        </div>
    </div>
</div>
@endsection
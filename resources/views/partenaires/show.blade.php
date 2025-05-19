@extends('layouts.app')

@section('title', 'Profil Partenaire: ' . $user->nom . ' ' . $user->prenom)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-2xl shadow-2xl p-8 transform transition-all duration-500 hover:shadow-3xl hover:-translate-y-1">
            <div class="flex items-center mb-8">
                <div class="relative">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-tr from-purple-400 to-blue-500 flex items-center justify-center text-6xl shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:from-pink-500 hover:to-purple-600">
                        <span class="text-white">👨‍💼</span> {{-- Emoji professionnel --}}
                        <div class="absolute -bottom-2 -right-2 bg-yellow-400 text-xs font-bold rounded-full px-2 py-1 shadow-md transform rotate-6">
                            PRO
                        </div>
                    </div>
                </div>
                <div class="ml-8">
                    <h1 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-blue-600">
                        {{ $user->nom }} {{ $user->prenom }}
                    </h1>
                    <p class="text-lg font-semibold text-gray-600 mt-1">Partenaire Premium</p>
                    <div class="flex mt-2">
                        @for($i = 0; $i < floor($user->evaluations()->avg('note_proprietaire')); $i++)
                            <span class="text-yellow-400 text-xl">★</span>
                        @endfor
                        @for($i = 0; $i < 5 - floor($user->evaluations()->avg('note_proprietaire')); $i++)
                            <span class="text-gray-300 text-xl">★</span>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Informations de base -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 border-b-2 border-purple-200 pb-2">
                        📋 Informations
                    </h2>
                    <div class="space-y-3">
                        <p class="flex items-center">
                            <span class="inline-block w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-3">
                                ✉️
                            </span>
                            <span class="font-medium text-gray-700">Email:</span>
                            <span class="ml-2 text-gray-600 hover:text-blue-600 transition-colors">
                                {{ $user->email }}
                            </span>
                        </p>
                        <p class="flex items-center">
                            <span class="inline-block w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mr-3">
                                🗓️
                            </span>
                            <span class="font-medium text-gray-700">Membre depuis:</span>
                            <span class="ml-2 text-gray-600 hover:text-purple-600 transition-colors">
                                {{ $user->created_at->format('d/m/Y') }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-teal-600 border-b-2 border-teal-200 pb-2">
                        📊 Statistiques
                    </h2>
                    <div class="space-y-3">
                        <p class="flex items-center">
                            <span class="inline-block w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 mr-3">
                                🏷️
                            </span>
                            <span class="font-medium text-gray-700">Nombre d'objets:</span>
                            <span class="ml-2 px-3 py-1 bg-gradient-to-r from-green-100 to-teal-100 rounded-full text-green-800 font-bold hover:from-green-200 hover:to-teal-200 transition-all">
                                {{ $user->objets()->count() }}
                            </span>
                        </p>
                        <p class="flex items-center">
                            <span class="inline-block w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 mr-3">
                                ⭐
                            </span>
                            <span class="font-medium text-gray-700">Note moyenne:</span>
                            <span class="ml-2 px-3 py-1 bg-gradient-to-r from-yellow-100 to-amber-100 rounded-full text-yellow-800 font-bold hover:from-yellow-200 hover:to-amber-200 transition-all">
                                {{ number_format($user->evaluations()->avg('note_proprietaire'), 1) }}/5
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Fiche Client: ' . $client->surnom)

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Effets de particules cosmiques -->
        <div class="absolute inset-0 overflow-hidden">
            @for ($i = 0; $i < 20; $i++)
                <div class="absolute rounded-full opacity-10 animate-float-{{ $i }}"
                    style="background: conic-gradient(from {{ rand(0, 360) }}deg, 
                        hsl({{ rand(200, 260) }}, 100%, 50%), 
                        hsl({{ rand(260, 320) }}, 100%, 50%));
                        width: {{ rand(5, 15) }}px; 
                        height: {{ rand(5, 15) }}px;
                        top: {{ rand(0, 100) }}%;
                        left: {{ rand(0, 100) }}%;
                        animation-delay: {{ $i * 0.3 }}s">
                </div>
            @endfor
        </div>

        <!-- Carte holographique principale -->
        <div class="max-w-4xl mx-auto transform perspective-1000">
            <div class="relative group">
                <!-- Halo holographique -->
                <div
                    class="absolute -inset-4 bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-pink-500/20 
                        rounded-3xl blur-xl opacity-70 group-hover:opacity-100 
                        rotate-x-60 rotate-y-0 rotate-z-0 transform-style-preserve-3d 
                        transition-all duration-1000 ease-[cubic-bezier(0.68,-0.55,0.265,1.55)]">
                </div>

                <!-- Carte principale -->
                <div
                    class="relative bg-gray-900/80 backdrop-blur-xl rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.6)] 
                       border border-white/10 overflow-hidden transform-style-preserve-3d 
                       transition-all duration-700 group-hover:rotate-x-3 group-hover:rotate-y-3 group-hover:translate-z-20">
                    <!-- En-tête avec effet néon -->
                    <div
                        class="p-8 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-b-3xl shadow-[inset_0_-15px_30px_rgba(0,0,0,0.2)]">
                        <div class="flex flex-col md:flex-row items-center">
                            <!-- Avatar holographique avec initiales -->
                            <div class="relative mb-6 md:mb-0 md:mr-8">
                                <div
                                    class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-500 to-blue-600 
                                        flex items-center justify-center text-4xl font-bold text-white shadow-[0_0_30px_rgba(139,92,246,0.7)] 
                                        border-4 border-white/80 hover:border-pink-300 hover:scale-105 transition-all duration-500
                                        uppercase tracking-wider">
                                    {{ substr($client->prenom, 0, 1) }}{{ substr($client->nom, 0, 1) }}
                                </div>
                                <div
                                    class="absolute -bottom-3 -right-3 bg-yellow-400 text-xs font-black rounded-full 
                                        px-3 py-1 shadow-lg transform rotate-12 border-2 border-yellow-200 z-10">
                                    VIP
                                </div>
                            </div>

                            <div>
                                <h1
                                    class="text-4xl font-black text-white tracking-tight drop-shadow-[0_2px_10px_rgba(167,139,250,0.8)]">
                                    {{ $client->surnom }}
                                </h1>
                                <div class="flex items-center mt-3">
                                    <span
                                        class="px-4 py-1.5 rounded-full text-sm font-bold bg-white/20 text-white 
                                           border border-white/30 shadow-[0_0_15px_rgba(255,255,255,0.3)] 
                                           flex items-center">
                                        <span class="mr-2">✨</span> Client Premium
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenu principal -->
                    <div class="p-8 space-y-8">
                        <!-- Cartes d'information 3D -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <!-- Suppression de la carte Note moyenne -->

                            

                            <!-- Nombre de locations -->
                            <div
                                class="bg-gradient-to-br from-pink-900/40 to-rose-900/40 p-5 rounded-xl 
                                    border border-pink-400/20 hover:shadow-[0_8px_25px_rgba(236,72,153,0.5)] 
                                    transition-all duration-500 hover:-translate-y-1.5">
                                <div class="text-sm text-pink-300 font-medium flex items-center">
                                    <span class="mr-2">🚗</span> Locations
                                </div>
                                <div class="mt-3">
                                    <span class="text-3xl font-black text-white">
                                        {{ $client->nombre_locations_effectuees_client }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Suppression de la section Historique des évaluations -->

                        <!-- Suppression de la section Commentaires conditionnelle -->

                        <!-- Section des évaluations du client -->
                        <div class="mt-8 space-y-6">
                            <h3
                                class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-purple-200 
                               mb-6 flex items-center">
                                <span class="mr-2">⭐</span> Évaluations des objets loués
                            </h3>

                            @forelse($client->evaluations()->with('objet', 'reservation.annonce.objet')->get() as $evaluation)
                                <div
                                    class="bg-gradient-to-br from-gray-800/50 to-purple-900/30 rounded-xl p-6 
                                    border border-purple-400/20 hover:shadow-[0_5px_20px_rgba(139,92,246,0.4)] 
                                    transition-all duration-300">
                                    <div class="flex items-start space-x-4">
                                        <!-- Image de l'objet -->
                                        <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden">
                                            @if (
                                                $evaluation->reservation &&
                                                    $evaluation->reservation->annonce &&
                                                    $evaluation->reservation->annonce->objet &&
                                                    $evaluation->reservation->annonce->objet->images &&
                                                    $evaluation->reservation->annonce->objet->images->first())
                                                <img src="{{ asset($evaluation->reservation->annonce->objet->images->first()->url) }}"
                                                    alt="Image de l'objet" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                                    <span class="text-2xl">📦</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            <!-- Nom de l'objet et note -->
                                            <div class="flex justify-between items-start">
                                                <h4 class="text-lg font-semibold text-white">
                                                    {{ $evaluation->reservation?->annonce?->objet?->nom ?? 'Objet indisponible' }}
                                                </h4>
                                                <div class="flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span
                                                            class="{{ $i <= $evaluation->note_objet ? 'text-yellow-400' : 'text-gray-600' }} text-lg">★</span>
                                                    @endfor
                                                </div>
                                            </div>

                                            <!-- Commentaire -->
                                            <p class="mt-2 text-gray-300">
                                                "{{ $evaluation->commentaire_objet }}"
                                            </p>

                                            <!-- Date et détails -->
                                            <div class="mt-3 flex items-center text-sm text-gray-400">
                                                <span class="mr-3 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $evaluation->created_at ? $evaluation->created_at->format('d/m/Y') : 'Date non disponible' }}
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    @if ($evaluation->reservation && $evaluation->reservation->date_debut && $evaluation->reservation->date_fin)
                                                        Location du
                                                        {{ $evaluation->reservation->date_debut->format('d/m/Y') }}
                                                        au {{ $evaluation->reservation->date_fin->format('d/m/Y') }}
                                                    @else
                                                        Dates de location non disponibles
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 bg-gray-800/50 rounded-xl border border-gray-700">
                                    <span class="text-4xl mb-4 block">📝</span>
                                    <p class="text-gray-400">Ce client n'a pas encore évalué d'objets.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Section des commentaires des partenaires -->
                        <div class="mt-12 pt-8 border-t border-white/10">
                            <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-200 to-purple-200 
                               mb-6 flex items-center">
                                <span class="mr-2">💬</span> Avis des partenaires
                            </h3>

                            @forelse($client->evaluationsRecues()->with('reservation.annonce.objet')->get() as $evaluation)
                                <div class="bg-gradient-to-br from-gray-800/50 to-purple-900/30 rounded-xl p-6 mb-6
                                    border border-purple-400/20 hover:shadow-[0_5px_20px_rgba(139,92,246,0.4)] 
                                    transition-all duration-300">
                                    
                                    <div class="flex justify-between items-start mb-4">
                                        <!-- Info partenaire -->
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-purple-600 
                                                flex items-center justify-center text-xl font-bold text-white
                                                border-2 border-white/20">
                                                {{ substr($evaluation->evalue->prenom, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <p class="font-semibold text-white">
                                                    {{ $evaluation->evalue->prenom }} {{ substr($evaluation->evalue->nom, 0, 1) }}.
                                                </p>
                                                <p class="text-sm text-gray-400">
                                                    {{ \Carbon\Carbon::parse($evaluation->date)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Note -->
                                        <div class="flex items-center bg-gray-800/50 px-3 py-1 rounded-full">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $evaluation->note_proprietaire ? 'text-yellow-400' : 'text-gray-600' }}">★</span>
                                            @endfor
                                        </div>
                                    </div>

                                    <!-- Commentaire -->
                                    <p class="text-gray-300 ml-16">
                                        "{{ $evaluation->commentaire_proprietaire }}"
                                    </p>

                                    <!-- Détails de la location -->
                                    <div class="mt-4 ml-16 flex items-center text-sm text-purple-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        <a href="{{ route('fiches.objet.show', $evaluation->reservation->annonce->objet->id) }}" 
                                           class="hover:text-purple-200 transition-colors">
                                            Location de : {{ $evaluation->reservation->annonce->objet->nom }}
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 bg-gray-800/50 rounded-xl border border-gray-700">
                                    <span class="text-4xl mb-4 block">💭</span>
                                    <p class="text-gray-400">Aucun avis reçu des partenaires pour le moment.</p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0) translateX(0) rotate(0deg);
            }

            25% {
                transform: translateY(-30px) translateX(10px) rotate(5deg);
            }

            50% {
                transform: translateY(-15px) translateX(-15px) rotate(-5deg);
            }

            75% {
                transform: translateY(-25px) translateX(15px) rotate(3deg);
            }
        }

        .perspective-1000 {
            perspective: 1000px;
        }

        .transform-style-preserve-3d {
            transform-style: preserve-3d;
        }

        .rotate-x-60 {
            transform: rotateX(60deg);
        }

        @for ($i = 0; $i < 20; $i++)
            .animate-float-{{ $i }} {
                animation: float {{ 12 + $i }}s ease-in-out infinite;
                animation-delay: {{ $i * 0.3 }}s;
            }
        @endfor
    </style>
@endsection

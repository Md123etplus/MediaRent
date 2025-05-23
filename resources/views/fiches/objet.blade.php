@extends('layouts.app')

@section('title', 'Fiche Objet: ' . $objet->nom)

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Effets de particules cosmiques -->
        <div class="absolute inset-0 overflow-hidden">
            @for ($i = 0; $i < 15; $i++)
                <div class="absolute rounded-full opacity-10 animate-float-{{ $i }}"
                    style="background: conic-gradient(from {{ rand(0, 360) }}deg, 
                        hsl({{ rand(200, 260) }}, 100%, 50%), 
                        hsl({{ rand(260, 320) }}, 100%, 50%));
                        width: {{ rand(5, 15) }}px; 
                        height: {{ rand(5, 15) }}px;
                        top: {{ rand(0, 100) }}%;
                        left: {{ rand(0, 100) }}%;
                        animation-delay: {{ $i * 0.5 }}s">
                </div>
            @endfor
        </div>

        <!-- Hologramme flottant -->
        <div class="max-w-6xl mx-auto transform perspective-1000">
            <div class="relative group">
                <!-- Effet holographique 3D -->
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
                    <!-- Galerie holographique -->
                    <div class="h-[500px] overflow-hidden relative group/gallery">
                        @if ($objet->images->count() > 0)
                            <img src="{{ asset($objet->images->first()->url) }}" alt="Photo de {{ $objet->nom }}"
                                class="w-full h-full object-cover transition-all duration-1000 group-hover/gallery:scale-110">

                            <!-- Effet de lumière -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                            </div>

                            <!-- Badge holographique -->
                            @if ($objet->images->count() > 1)
                                <div
                                    class="absolute top-6 right-6 bg-black/50 backdrop-blur-sm text-white px-4 py-2 
                                        rounded-full text-sm font-bold flex items-center border border-white/20 
                                        shadow-[0_0_15px_rgba(124,58,237,0.6)] hover:shadow-[0_0_25px_rgba(124,58,237,0.9)] 
                                        transition-all duration-500">
                                    <span class="text-yellow-300 mr-1">✨</span> +{{ $objet->images->count() - 1 }} photos
                                </div>
                            @endif
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                <div class="text-center p-8 backdrop-blur-sm rounded-xl border border-white/10">
                                    <span class="text-8xl opacity-50">🖼️</span>
                                    <p class="text-white/50 mt-4 text-lg">Aucune photo disponible</p>
                                </div>
                            </div>
                        @endif

                        <!-- Miniatures holographiques -->
                        @if ($objet->images->count() > 1)
                            <div
                                class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-4 
                                    bg-black/50 backdrop-blur-md p-3 rounded-xl border border-white/10 
                                    shadow-[0_10px_25px_-5px_rgba(0,0,0,0.5)]">
                                @foreach ($objet->images->take(5) as $image)
                                    <div
                                        class="relative w-16 h-16 rounded-lg overflow-hidden border-2 border-white/20 
                                            hover:border-purple-400 hover:scale-125 hover:z-10 
                                            transition-all duration-300 cursor-pointer shadow-lg 
                                            hover:shadow-[0_0_20px_rgba(168,85,247,0.7)]">
                                        <img src="{{ asset($image->url) }}" alt="Photo supplémentaire"
                                            class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/30 hover:bg-transparent transition"></div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Contenu principal -->
                    <div class="p-8 space-y-8">
                        <!-- En-tête avec effet néon -->
                        <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-3 mb-3">
                                    <h1
                                        class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-300 via-purple-300 to-pink-300 
                                           tracking-tight drop-shadow-[0_2px_10px_rgba(167,139,250,0.6)]">
                                        {{ $objet->nom }}
                                    </h1>
                                    <span
                                        class="px-4 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-purple-900/50 to-blue-900/50 
                                            text-purple-200 border border-purple-400/30 shadow-[inset_0_1px_5px_rgba(255,255,255,0.3)] 
                                            flex items-center hover:shadow-[0_0_15px_rgba(139,92,246,0.5)] transition">
                                        <span class="mr-1.5">🏷️</span> {{ $objet->categorie->nom }}
                                    </span>
                                </div>
                                <div class="flex items-center text-purple-100/80 text-lg">
                                    <span class="mr-2 text-purple-300">📍</span> {{ $objet->ville }}
                                </div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-blue-900/40 to-purple-900/40 p-5 rounded-xl 
                                    border border-blue-400/20 shadow-[0_5px_15px_rgba(59,130,246,0.3)] 
                                    hover:shadow-[0_8px_25px_rgba(59,130,246,0.5)] transition">
                                <div class="text-4xl font-black text-white">
                                    {{ number_format($objet->prix_journalier, 2) }} <span
                                        class="text-xl text-blue-200">€/jour</span>
                                </div>
                                <div class="text-sm text-blue-300 font-medium mt-1">TVA incluse</div>
                            </div>
                        </div>

                        <!-- Cartes d'information 3D -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <!-- État -->
                            <div
                                class="bg-gradient-to-br from-green-900/40 to-emerald-900/40 p-5 rounded-xl 
                                    border border-green-400/20 hover:shadow-[0_8px_25px_rgba(74,222,128,0.4)] 
                                    transition-all duration-500 hover:-translate-y-1.5">
                                <div class="text-sm text-green-300 font-medium flex items-center">
                                    <span class="mr-2">🔄</span> État
                                </div>
                                <div class="font-bold text-white text-xl mt-2 capitalize flex items-center">
                                    <span
                                        class="w-3 h-3 rounded-full bg-green-400 mr-2 shadow-[0_0_8px_rgba(74,222,128,0.7)]"></span>
                                    {{ $objet->etat }}
                                </div>
                            </div>

                            <!-- Note moyenne -->
                            <div
                                class="bg-gradient-to-br from-amber-900/40 to-yellow-900/40 p-5 rounded-xl 
                                    border border-amber-400/20 hover:shadow-[0_8px_25px_rgba(234,179,8,0.4)] 
                                    transition-all duration-500 hover:-translate-y-1.5">
                                <div class="text-sm text-amber-300 font-medium flex items-center">
                                    <span class="mr-2">⭐</span> Note moyenne
                                </div>
                                <div class="flex items-center mt-2">
                                    <span class="text-3xl font-black text-white mr-3">{{ number_format($note, 1) }}</span>
                                    <div class="flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($note))
                                                <span
                                                    class="text-amber-400 text-xl drop-shadow-[0_0_5px_rgba(234,179,8,0.7)]">★</span>
                                            @else
                                                <span class="text-gray-500 text-xl">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <!-- Disponibilité -->
                            <div
                                class="bg-gradient-to-br from-gray-800/50 to-blue-900/40 p-5 rounded-xl 
                                    border border-blue-400/20 hover:shadow-[0_8px_25px_rgba(59,130,246,0.4)] 
                                    transition-all duration-500 hover:-translate-y-1.5">
                                <div class="text-sm text-blue-300 font-medium flex items-center">
                                    <span class="mr-2">📅</span> Disponibilité
                                </div>
                                <div class="mt-2">
                                    <span
                                        class="px-3 py-1.5 rounded-full text-sm font-bold 
                                    {{ $disponible ? 'bg-green-900/50 text-green-200 border border-green-400/30 shadow-[0_0_10px_rgba(74,222,128,0.3)]' : 'bg-red-900/50 text-red-200 border border-red-400/30 shadow-[0_0_10px_rgba(248,113,113,0.3)]' }} 
                                    flex items-center justify-center w-min">
                                        <span class="mr-1.5">{{ $disponible ? '✅' : '❌' }}</span>
                                        {{ $disponible ? 'Disponible' : 'Indisponible' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Description avec effet de parchemin -->
                        <div
                            class="mt-10 bg-gradient-to-br from-gray-800/50 to-purple-900/30 p-8 rounded-2xl 
                                border border-purple-400/20 shadow-[inset_0_5px_15px_rgba(0,0,0,0.3)]">
                            <h2
                                class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-purple-200 
                                   mb-6 flex items-center drop-shadow-[0_2px_5px_rgba(167,139,250,0.5)]">
                                <span class="mr-3">📜</span> Description
                            </h2>
                            <div class="prose prose-invert max-w-none text-gray-200 border-l-2 border-purple-400/50 pl-6">
                                {{ $objet->description }}
                            </div>
                        </div>

                        <!-- Propriétaire avec carte VIP -->
                        <div class="mt-12 pt-8 border-t border-white/10">
                            <h2
                                class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-pink-200 
                                   mb-6 flex items-center drop-shadow-[0_2px_5px_rgba(236,72,153,0.3)]">
                                <span class="mr-3">👑</span> Proposé par
                            </h2>
                            <a href="{{ route('partenaire.show', $objet->proprietaire->id) }}"
                                class="block hover:transform hover:scale-105 transition-all duration-300">
                                <div
                                    class="flex items-center p-6 bg-gradient-to-br from-gray-800/60 to-indigo-900/50 rounded-2xl 
                                        border border-indigo-400/30 hover:shadow-[0_10px_30px_rgba(79,70,229,0.4)] 
                                        transition-all duration-500 cursor-pointer group/owner">
                                    <div class="relative">
                                        <div
                                            class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-500 to-blue-600 
                                                flex items-center justify-center text-4xl shadow-[0_0_20px_rgba(139,92,246,0.6)] 
                                                group-hover/owner:shadow-[0_0_30px_rgba(139,92,246,0.9)] transition">
                                            👨
                                        </div>
                                        <div
                                            class="absolute -bottom-1 -right-1 bg-yellow-400 text-xs font-black rounded-full 
                                                px-2 py-0.5 shadow-md transform rotate-6 border border-yellow-200">
                                            PARTENAIRE
                                        </div>
                                    </div>
                                    <div class="ml-6">
                                        <p class="font-bold text-white text-xl">{{ $objet->proprietaire->nom }}
                                            {{ $objet->proprietaire->prenom }}</p>
                                        <div class="flex items-center text-sm text-purple-200/80 mt-2">
                                            <span class="mr-2">📅</span> Membre depuis
                                            {{ $objet->proprietaire->created_at->format('M Y') }}
                                        </div>
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            <span
                                                class="text-xs bg-blue-900/50 text-blue-200 px-3 py-1 rounded-full 
                                                   flex items-center border border-blue-400/30">
                                                <span class="mr-1.5">📦</span>
                                                {{ $objet->proprietaire->objets_count ?? 0 }} objets proposés
                                            </span>
                                            @if ($objet->proprietaire->note_moyenne)
                                                <span
                                                    class="text-xs bg-green-900/50 text-green-200 px-3 py-1 rounded-full 
                                                       flex items-center border border-green-400/30">
                                                    <span class="mr-1.5">⭐</span> Note:
                                                    {{ number_format($objet->proprietaire->note_moyenne, 1) }}/5
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mt-4">
                                            <span class="text-sm text-indigo-300 hover:text-indigo-200 flex items-center">
                                                Voir le profil complet
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 ml-1 group-hover/owner:translate-x-1 transition-transform"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Bouton de réservation futuriste -->
                        @if ($disponible)
                            <div class="mt-12">
                                <a href="{{ route('annonces.index') }}"
                                    class="w-full group relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 
                                        text-white px-8 py-6 rounded-2xl font-black text-xl tracking-wide 
                                        hover:shadow-[0_15px_35px_rgba(99,102,241,0.5)] transition-all duration-700 
                                        transform hover:-translate-y-1.5 flex items-center justify-center">
                                    <span class="relative z-10 flex items-center justify-center">
                                        <span class="mr-3 text-2xl">🚀</span>
                                        <span class="drop-shadow-[0_2px_5px_rgba(255,255,255,0.4)]">Réserver
                                            maintenant</span>
                                    </span>
                                    <span
                                        class="absolute inset-0 bg-gradient-to-r from-blue-700 via-purple-700 to-pink-700 
                                        opacity-0 group-hover:opacity-100 transition-opacity duration-700"></span>
                                    <span
                                        class="absolute -inset-2 bg-white/10 rounded-2xl transform rotate-3 scale-110 
                                        group-hover:rotate-0 group-hover:scale-105 transition-all duration-1000"></span>
                                    <span
                                        class="absolute -inset-4 opacity-0 group-hover:opacity-100 transition-opacity duration-1000">
                                        <span
                                            class="absolute top-0 right-0 w-16 h-16 -mt-5 -mr-5 bg-white rounded-full 
                                            opacity-20 animate-ping-slow"></span>
                                    </span>
                                </a>
                            </div>
                        @endif
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

        @keyframes ping-slow {
            0% {
                transform: scale(0.5);
                opacity: 0.8;
            }

            70%,
            100% {
                transform: scale(3);
                opacity: 0;
            }
        }

        .animate-ping-slow {
            animation: ping-slow 3s infinite cubic-bezier(0, 0, 0.2, 1);
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

        @for ($i = 0; $i < 15; $i++)
            .animate-float-{{ $i }} {
                animation: float {{ 15 + $i }}s ease-in-out infinite;
                animation-delay: {{ $i * 0.7 }}s;
            }
        @endfor
    </style>
@endsection

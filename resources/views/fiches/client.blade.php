@extends('layouts.app')

@section('title', 'Fiche Client: ' . $client->surnom)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
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
            <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-pink-500/20 
                        rounded-3xl blur-xl opacity-70 group-hover:opacity-100 
                        rotate-x-60 rotate-y-0 rotate-z-0 transform-style-preserve-3d 
                        transition-all duration-1000 ease-[cubic-bezier(0.68,-0.55,0.265,1.55)]"></div>
            
            <!-- Carte principale -->
            <div class="relative bg-gray-900/80 backdrop-blur-xl rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.6)] 
                       border border-white/10 overflow-hidden transform-style-preserve-3d 
                       transition-all duration-700 group-hover:rotate-x-3 group-hover:rotate-y-3 group-hover:translate-z-20">
                <!-- En-tête avec effet néon -->
                <div class="p-8 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-b-3xl shadow-[inset_0_-15px_30px_rgba(0,0,0,0.2)]">
                    <div class="flex flex-col md:flex-row items-center">
                        <!-- Avatar holographique -->
                        <div class="relative mb-6 md:mb-0 md:mr-8">
                            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-500 to-blue-600 
                                        flex items-center justify-center text-5xl shadow-[0_0_30px_rgba(139,92,246,0.7)] 
                                        border-4 border-white/80 hover:border-pink-300 hover:scale-105 transition-all duration-500">
                                @if($client->img_profil)
                                    <img src="{{ $client->img_profil }}" alt="Profil de {{ $client->surnom }}" 
                                         class="w-full h-full rounded-full object-cover">
                                @else
                                    <span class="text-white">👤</span>
                                @endif
                            </div>
                            <div class="absolute -bottom-3 -right-3 bg-yellow-400 text-xs font-black rounded-full 
                                        px-3 py-1 shadow-lg transform rotate-12 border-2 border-yellow-200 z-10">
                                VIP
                            </div>
                        </div>
                        
                        <div>
                            <h1 class="text-4xl font-black text-white tracking-tight drop-shadow-[0_2px_10px_rgba(167,139,250,0.8)]">
                                {{ $client->surnom }}
                            </h1>
                            <div class="flex items-center mt-3">
                                <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-white/20 text-white 
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
                        <!-- Note moyenne -->
                        <div class="bg-gradient-to-br from-purple-900/40 to-indigo-900/40 p-5 rounded-xl 
                                    border border-purple-400/20 hover:shadow-[0_8px_25px_rgba(139,92,246,0.5)] 
                                    transition-all duration-500 hover:-translate-y-1.5">
                            <div class="text-sm text-purple-300 font-medium flex items-center">
                                <span class="mr-2">⭐</span> Note moyenne
                            </div>
                            <div class="mt-3 flex items-center">
                                <span class="text-3xl font-black text-white mr-3">
                                    {{ number_format($client->note_moyenne_client, 1) ?? 'N/A' }}
                                </span>
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($client->note_moyenne_client))
                                            <span class="text-yellow-400 text-xl drop-shadow-[0_0_5px_rgba(234,179,8,0.7)]">★</span>
                                        @else
                                            <span class="text-gray-500 text-xl">★</span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        
                        <!-- Nombre d'avis -->
                        <div class="bg-gradient-to-br from-blue-900/40 to-indigo-900/40 p-5 rounded-xl 
                                    border border-blue-400/20 hover:shadow-[0_8px_25px_rgba(59,130,246,0.5)] 
                                    transition-all duration-500 hover:-translate-y-1.5">
                            <div class="text-sm text-blue-300 font-medium flex items-center">
                                <span class="mr-2">💬</span> Avis reçus
                            </div>
                            <div class="mt-3">
                                <span class="text-3xl font-black text-white">
                                    {{ $client->nombre_avis_client }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Nombre de locations -->
                        <div class="bg-gradient-to-br from-pink-900/40 to-rose-900/40 p-5 rounded-xl 
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

                    <!-- Graphique d'évaluation (placeholder) -->
                    <div class="mt-8 bg-gradient-to-br from-gray-800/60 to-indigo-900/50 rounded-2xl 
                                border border-indigo-400/30 p-6 hover:shadow-[0_10px_30px_rgba(79,70,229,0.4)] 
                                transition-all duration-500">
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-purple-200 
                                   mb-4 flex items-center">
                            <span class="mr-2">📊</span> Historique des évaluations
                        </h3>
                        <div class="h-40 flex items-center justify-center text-gray-400">
                            [Graphique des évaluations]
                        </div>
                    </div>

                    <!-- Section commentaires (conditionnelle) -->
                    @if(false)
                    <div class="mt-8 pt-6 border-t border-white/10">
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-200 to-rose-200 
                                   mb-6 flex items-center">
                            <span class="mr-2">💎</span> Commentaires Premium
                        </h3>
                        
                        <!-- Carte commentaire -->
                        <div class="bg-gradient-to-br from-gray-800/50 to-purple-900/30 rounded-xl p-6 mb-4 
                                    border border-purple-400/20 hover:shadow-[0_5px_20px_rgba(139,92,246,0.4)] 
                                    transition-all duration-300">
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center 
                                            text-xl mr-4 border border-purple-400/30">
                                    👔
                                </div>
                                <div>
                                    <div class="flex items-center mb-2">
                                        <span class="font-bold text-white mr-3">Jean D.</span>
                                        <div class="flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="text-yellow-400 text-sm">★</span>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-300">
                                        "Client exceptionnel, très respectueux du matériel. Je recommande vivement!"
                                    </p>
                                    <div class="text-xs text-gray-400 mt-3 flex items-center">
                                        <span class="mr-2">📅</span> 15 Mars 2023
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
        25% { transform: translateY(-30px) translateX(10px) rotate(5deg); }
        50% { transform: translateY(-15px) translateX(-15px) rotate(-5deg); }
        75% { transform: translateY(-25px) translateX(15px) rotate(3deg); }
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
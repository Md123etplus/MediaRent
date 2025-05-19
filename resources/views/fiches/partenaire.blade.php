@extends('layouts.app')

@section('title', 'Fiche Partenaire: ' . $partenaire->surnom)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Effets de particules lumineuses -->
    <div class="absolute inset-0 overflow-hidden">
        @for ($i = 0; $i < 20; $i++)
            <div class="absolute rounded-full opacity-10 animate-float-{{ $i }}" 
                 style="background: conic-gradient(from {{ rand(0, 360) }}deg, 
                        hsl({{ rand(200, 240) }}, 80%, 80%), 
                        hsl({{ rand(240, 280) }}, 80%, 80%));
                        width: {{ rand(5, 15) }}px; 
                        height: {{ rand(5, 15) }}px;
                        top: {{ rand(0, 100) }}%;
                        left: {{ rand(0, 100) }}%;
                        animation-delay: {{ $i * 0.3 }}s">
            </div>
        @endfor
    </div>

    <!-- Carte holographique principale -->
    <div class="max-w-6xl mx-auto transform perspective-1000">
        <div class="relative group">
            <!-- Halo lumineux -->
            <div class="absolute -inset-4 bg-gradient-to-r from-cyan-200/30 via-blue-200/30 to-indigo-200/30 
                        rounded-3xl blur-xl opacity-70 group-hover:opacity-100 
                        rotate-x-60 rotate-y-0 rotate-z-0 transform-style-preserve-3d 
                        transition-all duration-1000 ease-[cubic-bezier(0.68,-0.55,0.265,1.55)]"></div>
            
            <!-- Carte principale -->
            <div class="relative bg-white/95 backdrop-blur-md rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.1)] 
                       border border-white/20 overflow-hidden transform-style-preserve-3d 
                       transition-all duration-700 group-hover:rotate-x-3 group-hover:rotate-y-3 group-hover:translate-z-20">
                
                <!-- En-tête avec effet néon clair -->
                <div class="p-10 bg-gradient-to-r from-cyan-400 via-blue-400 to-indigo-500 rounded-b-3xl shadow-[inset_0_-15px_30px_rgba(255,255,255,0.2)] relative overflow-hidden">
                    <div class="flex flex-col md:flex-row items-center relative z-10">
                        <!-- Avatar holographique -->
                        <div class="relative mb-8 md:mb-0 md:mr-10">
                            <div class="w-36 h-36 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 
                                        flex items-center justify-center text-6xl text-white shadow-[0_0_30px_rgba(34,211,238,0.5)] 
                                        border-4 border-white/90 hover:border-cyan-300 hover:scale-105 transition-all duration-500">
                                <span class="text-5xl">👨‍💼</span>
                            </div>
                            <div class="absolute -bottom-4 -right-4 bg-yellow-400 text-xs font-black rounded-full 
                                        px-4 py-1 shadow-xl transform rotate-12 border-2 border-yellow-200 z-10">
                                PRO
                            </div>
                        </div>
                        
                        <div>
                            <h1 class="text-5xl font-black text-white tracking-tight drop-shadow-[0_2px_10px_rgba(34,211,238,0.6)]">
                                {{ $partenaire->surnom }}
                            </h1>
                            <div class="flex flex-wrap items-center gap-3 mt-4">
                                <span class="px-5 py-2 rounded-full text-sm font-bold bg-white/30 text-white 
                                           border border-white/40 shadow-[0_0_15px_rgba(255,255,255,0.3)] 
                                           flex items-center backdrop-blur-sm">
                                    <span class="mr-2">✨</span> Partenaire Premium
                                </span>
                                <span class="px-5 py-2 rounded-full text-sm font-bold bg-cyan-600/20 text-cyan-800 
                                           border border-cyan-400/50 shadow-[0_0_10px_rgba(34,211,238,0.2)] 
                                           flex items-center">
                                    <span class="mr-2">📅</span> Membre depuis {{ $partenaire->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu principal -->
                <div class="p-10 space-y-10">
                    <!-- Statistiques en cartes 3D -->
                    <div>
                        <h2 class="text-3xl font-black mb-8 text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 to-blue-600 
                                   drop-shadow-[0_2px_5px_rgba(34,211,238,0.3)] flex items-center">
                            <span class="mr-3">📊</span> Performances
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                            <!-- Note moyenne -->
                            <div class="bg-gradient-to-br from-cyan-100 to-blue-100 p-6 rounded-xl 
                                        border border-cyan-200 hover:shadow-[0_8px_25px_rgba(34,211,238,0.2)] 
                                        transition-all duration-500 hover:-translate-y-1.5 group">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 rounded-full bg-cyan-100 flex items-center justify-center 
                                                mr-5 border border-cyan-200 group-hover:bg-cyan-200 transition">
                                        <span class="text-2xl text-cyan-600">⭐</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-cyan-600">Note moyenne</span>
                                        <span class="text-3xl font-black text-gray-800">
                                            {{ number_format($partenaire->note_moyenne_partenaire, 1) ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Nombre d'avis -->
                            <div class="bg-gradient-to-br from-blue-100 to-indigo-100 p-6 rounded-xl 
                                        border border-blue-200 hover:shadow-[0_8px_25px_rgba(59,130,246,0.2)] 
                                        transition-all duration-500 hover:-translate-y-1.5 group">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center 
                                                mr-5 border border-blue-200 group-hover:bg-blue-200 transition">
                                        <span class="text-2xl text-blue-600">💬</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-blue-600">Avis reçus</span>
                                        <span class="text-3xl font-black text-gray-800">
                                            {{ $partenaire->nombre_avis_partenaire }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Annonces publiées -->
                            <div class="bg-gradient-to-br from-indigo-100 to-purple-100 p-6 rounded-xl 
                                        border border-indigo-200 hover:shadow-[0_8px_25px_rgba(99,102,241,0.2)] 
                                        transition-all duration-500 hover:-translate-y-1.5 group">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center 
                                                mr-5 border border-indigo-200 group-hover:bg-indigo-200 transition">
                                        <span class="text-2xl text-indigo-600">📋</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-indigo-600">Annonces</span>
                                        <span class="text-3xl font-black text-gray-800">
                                            {{ $partenaire->nombre_annonces_publiees }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Locations réalisées -->
                            <div class="bg-gradient-to-br from-purple-100 to-pink-100 p-6 rounded-xl 
                                        border border-purple-200 hover:shadow-[0_8px_25px_rgba(168,85,247,0.2)] 
                                        transition-all duration-500 hover:-translate-y-1.5 group">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center 
                                                mr-5 border border-purple-200 group-hover:bg-purple-200 transition">
                                        <span class="text-2xl text-purple-600">🚀</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-purple-600">Locations</span>
                                        <span class="text-3xl font-black text-gray-800">
                                            {{ $partenaire->nombre_locations_realisees_partenaire }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventaire -->
                    <div class="pt-8 border-t border-gray-200">
                        <h2 class="text-3xl font-black mb-8 text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-500 
                                   drop-shadow-[0_2px_5px_rgba(244,114,182,0.3)] flex items-center">
                            <span class="mr-3">🛍️</span> Inventaire
                        </h2>
                        
                        @if($partenaire->objets_en_ligne->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($partenaire->objets_en_ligne as $objet)
                                    <div class="relative group transform-style-preserve-3d 
                                               transition-all duration-500 hover:-translate-y-2 hover:rotate-y-2">
                                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-200/20 to-pink-200/20 
                                                    rounded-xl blur opacity-70 group-hover:opacity-100 
                                                    transition-all duration-700"></div>
                                        
                                        <div class="relative bg-white rounded-xl border border-gray-200 
                                                   overflow-hidden shadow-lg hover:shadow-xl 
                                                   transition-all duration-300 h-full">
                                            <div class="relative h-56 overflow-hidden">
                                                <img src="{{ $objet->premiere_image_url }}" alt="{{$objet->nom}}" 
                                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                                                <span class="absolute top-4 right-4 bg-pink-500 text-white text-xs font-bold px-3 py-1 
                                                          rounded-full shadow-md">
                                                    {{ number_format($objet->prix_journalier, 2, ',', ' ') }} €/jour
                                                </span>
                                            </div>
                                            <div class="p-5">
                                                <a href="{{ route('fiches.objet.show', $objet->id) }}" 
                                                   class="text-xl font-bold text-gray-800 hover:text-indigo-600 transition-colors block mb-2">
                                                    {{ $objet->nom }}
                                                </a>
                                                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium 
                                                          rounded-full mb-3 border border-indigo-200">
                                                    {{ $objet->categorie->nom ?? 'Non catégorisé' }}
                                                </span>
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <span class="mr-1">📍</span> {{ $objet->ville }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 bg-gray-100 rounded-xl border border-dashed border-gray-300">
                                <div class="mx-auto w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mb-4 
                                          border border-pink-300 shadow-sm">
                                    <span class="text-4xl text-pink-500">😕</span>
                                </div>
                                <h3 class="text-xl font-medium text-gray-700 mb-2">Aucun objet en ligne</h3>
                                <p class="text-gray-500 max-w-md mx-auto">Ce partenaire n'a actuellement aucun objet disponible à la location.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Section Avis des clients -->
                    <div class="pt-8 border-t border-gray-200">
                        <h2 class="text-3xl font-black mb-8 text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 to-blue-500 
                                   drop-shadow-[0_2px_5px_rgba(34,211,238,0.3)] flex items-center">
                            <span class="mr-3">💭</span> Avis des clients
                        </h2>
                        
                        @if($partenaire->evaluationsRecues->count() > 0)
                            <div class="space-y-6">
                                @foreach($partenaire->evaluationsRecues as $evaluation)
                                    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                                        <div class="flex items-start gap-4">
                                            <!-- Avatar du client -->
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 
                                                     flex items-center justify-center text-lg font-bold text-white">
                                                {{ substr($evaluation->evaluateur->prenom, 0, 1) }}{{ substr($evaluation->evaluateur->nom, 0, 1) }}
                                            </div>
                                            
                                            <div class="flex-1">
                                                <!-- En-tête avec nom et note -->
                                                <div class="flex justify-between items-start mb-3">
                                                    <div>
                                                        <h3 class="font-bold text-gray-900">
                                                            {{ $evaluation->evaluateur->prenom }} {{ substr($evaluation->evaluateur->nom, 0, 1) }}.
                                                        </h3>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $evaluation->created_at->format('d M Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="flex gap-1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-5 h-5 {{ $i <= $evaluation->note_proprietaire ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                                 fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                </div>
                                                
                                                <!-- Commentaire -->
                                                <p class="text-gray-700 mt-2">
                                                    "{{ $evaluation->commentaire_proprietaire }}"
                                                </p>
                                                
                                                <!-- Objet loué -->
                                                <div class="mt-3 flex items-center text-sm text-cyan-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                                    </svg>
                                                    Location : {{ $evaluation->reservation->annonce->objet->nom }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                <div class="mx-auto w-24 h-24 bg-cyan-100 rounded-full flex items-center justify-center mb-4">
                                    <span class="text-4xl">💬</span>
                                </div>
                                <h3 class="text-xl font-medium text-gray-700">Aucun avis pour le moment</h3>
                                <p class="text-gray-500 mt-2">Ce partenaire n'a pas encore reçu d'évaluations.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
        25% { transform: translateY(-15px) translateX(10px) rotate(5deg); }
        50% { transform: translateY(-10px) translateX(-10px) rotate(-5deg); }
        75% { transform: translateY(-12px) translateX(10px) rotate(3deg); }
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
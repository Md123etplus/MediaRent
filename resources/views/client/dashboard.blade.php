@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Sidebar moderne et simplifié (fixed) -->
    <div class="hidden md:flex md:w-64 md:flex-col fixed h-full z-20">
        <div class="flex flex-col flex-grow bg-gradient-to-br from-blue-600 via-indigo-600 to-indigo-800 pt-6 pb-4 overflow-y-auto shadow-2xl rounded-r-2xl">
            <!-- Logo et titre -->
            <div class="flex items-center flex-shrink-0 px-6 mb-10">
                <svg class="w-8 h-8 mr-3 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                </svg>
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">MediaRent</h2>
                    <p class="text-xs text-blue-200 opacity-80">Plateforme de location</p>
                </div>
            </div>
            
          <!-- Profil utilisateur -->
<div class="px-6 mb-8">
    <div class="flex items-center p-4 bg-white/10 rounded-xl backdrop-blur-sm border border-white/10 transition-all duration-300 hover:bg-white/15">
        <div class="flex-shrink-0">
            <div class="relative">
                <img class="h-12 w-12 rounded-full object-cover border-2 border-white/40 shadow-lg" 
                     src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->prenom.' '.auth()->user()->nom) }}" 
                     alt="{{ auth()->user()->prenom }}">
                <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-400 border-2 border-white"></span>
            </div>
        </div>
        <div class="ml-4 max-w-[calc(100%-4rem)]">
            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
            <p class="text-xs text-blue-200 opacity-80 break-words">{{ auth()->user()->email }}</p>
        </div>
    </div>
</div>
            <!-- Menu principal -->
            <div class="flex-grow flex flex-col px-4">
                <div class="mb-2 px-4">
                    <h3 class="text-xs uppercase tracking-wider text-blue-200 opacity-80 font-semibold">Menu principal</h3>
                </div>
                
                <nav class="space-y-3">
                    <!-- Tableau de bord -->
                    <a href="{{ route('client.index') }}" class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 ease-in-out transform hover:scale-102
                        {{ request()->routeIs('client.dashboard') ? 'bg-white/20 text-white shadow-lg' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        
                        <!-- Indicateur actif -->
                        @if(request()->routeIs('client.dashboard'))
                            <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-white rounded-r-full shadow-md"></span>
                        @endif
                        
                        <div class="mr-3 flex-shrink-0 transition-all duration-300 
                            {{ request()->routeIs('client.dashboard') ? 'bg-white/30 shadow-lg' : 'bg-white/10 group-hover:bg-white/20' }} 
                            p-2.5 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <span>Tableau de bord</span>
                        @if(request()->routeIs('client.dashboard'))
                            <span class="ml-auto bg-white/30 py-0.5 px-2 rounded-md text-xs font-medium shadow-sm">Actif</span>
                        @endif
                    </a>
                    
                    <!-- Mes réservations -->
                    <a href="{{ route('client.reservations.index') }}" class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 ease-in-out transform hover:scale-102
                        {{ request()->routeIs('client.reservations*') ? 'bg-white/20 text-white shadow-lg' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        
                        <!-- Indicateur actif -->
                        @if(request()->routeIs('client.reservations*'))
                            <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-white rounded-r-full shadow-md"></span>
                        @endif
                        
                        <div class="mr-3 flex-shrink-0 transition-all duration-300 
                            {{ request()->routeIs('client.reservations*') ? 'bg-white/30 shadow-lg' : 'bg-white/10 group-hover:bg-white/20' }} 
                            p-2.5 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span>Mes réservations</span>
                        @if(isset($ongoingReservations) && $ongoingReservations > 0)
                            <span class="ml-auto bg-blue-400/50 py-0.5 px-2 rounded-md text-xs font-medium shadow-sm animate-pulse">{{ $ongoingReservations }}</span>
                        @endif
                    </a>

                    <!-- État des livraisons -->
                    <a href="{{ route('client.reservations.livraisons') }}" 
                       class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 ease-in-out transform hover:scale-102
                        {{ request()->routeIs('client.reservations.livraisons') ? 'bg-white/20 text-white shadow-lg' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        
                        <!-- Indicateur actif -->
                        @if(request()->routeIs('client.reservations.livraisons'))
                            <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-white rounded-r-full shadow-md"></span>
                        @endif
                        
                        <div class="mr-3 flex-shrink-0 transition-all duration-300 
                            {{ request()->routeIs('client.reservations.livraisons') ? 'bg-white/30 shadow-lg' : 'bg-white/10 group-hover:bg-white/20' }} 
                            p-2.5 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                        <span>État des livraisons</span>
                        @if(isset($pendingDeliveries) && $pendingDeliveries > 0)
                            <span class="ml-auto bg-yellow-400/50 py-0.5 px-2 rounded-md text-xs font-medium shadow-sm animate-pulse">
                                {{ $pendingDeliveries }}
                            </span>
                        @endif
                    </a>
                </nav>
            </div>
            
            <!-- Section décoration -->
            <div class="px-6 mt-8 mb-6">
                <div class="bg-gradient-to-r from-blue-900/40 to-indigo-900/40 rounded-xl p-5 backdrop-blur-sm border border-white/10 shadow-lg transform transition-all duration-300 hover:scale-102 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-500/30 rounded-lg mr-4 shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Nouveautés</p>
                            <p class="text-xs text-blue-200 opacity-80">Découvrez nos offres</p>
                        </div>
                    </div>
                    <button onclick="window.location.href='{{ route('annonces.search') }}'" 
        class="mt-4 w-full py-2.5 px-3 bg-white/20 hover:bg-white/30 text-white text-sm font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
    Explorer
</button>
                </div>
            </div>
            
            <!-- Section statique décorative -->
            <div class="px-6 mt-auto">
                <div class="p-4 rounded-xl bg-gradient-to-r from-indigo-900/30 to-blue-900/30 border border-white/10 backdrop-blur-sm shadow-md">
                    <div class="flex items-center mb-3">
                        <div class="p-2 bg-blue-500/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-white">Dernière connexion</p>
                    </div>
                    <p class="text-xs text-blue-200 opacity-80">{{ now()->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
            
            <!-- Déconnexion -->
            <div class="px-6 mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-300 bg-white/10 text-white hover:bg-white/20 shadow-md hover:shadow-lg transform hover:scale-102">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu button -->
    <div class="md:hidden fixed top-4 left-4 z-30">
        <button type="button" id="sidebar-toggle" class="p-2 rounded-lg bg-white/80 backdrop-blur-sm shadow-lg text-blue-600 hover:text-blue-800 focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
    
    <!-- Mobile menu (hidden by default) -->
    <div id="mobile-menu" class="md:hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-20 transform -translate-x-full transition-transform duration-300 ease-in-out">
        <div class="relative w-72 max-w-sm h-full bg-gradient-to-br from-blue-600 via-indigo-600 to-indigo-800 overflow-y-auto">
            <!-- Header mobile -->
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-2 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-white">MediaRent</h2>
                </div>
                <button id="close-sidebar" class="text-white hover:text-blue-200 p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Contenu du mobile sidebar -->
            <div class="px-6 mb-8">
                <div class="flex items-center p-4 bg-white/10 rounded-xl backdrop-blur-sm border border-white/10">
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <img class="h-12 w-12 rounded-full object-cover border-2 border-white/40 shadow-lg" 
                                 src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->prenom.' '.auth()->user()->nom) }}" 
                                 alt="{{ auth()->user()->prenom }}">
                            <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-400 border-2 border-white"></span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
                        <p class="text-xs text-blue-200 opacity-80">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Menu mobile -->
            <div class="px-4 mb-8">
                <h3 class="mb-2 px-4 text-xs uppercase tracking-wider text-blue-200 opacity-80 font-semibold">Menu principal</h3>
                <nav class="space-y-3">
                    <!-- Tableau de bord mobile -->
                    <a href="{{ route('client.index') }}" class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300
                        {{ request()->routeIs('client.dashboard') ? 'bg-white/20 text-white shadow-lg' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        
                        @if(request()->routeIs('client.dashboard'))
                            <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-white rounded-r-full shadow-md"></span>
                        @endif
                        
                        <div class="mr-3 flex-shrink-0
                            {{ request()->routeIs('client.dashboard') ? 'bg-white/30 shadow-lg' : 'bg-white/10 group-hover:bg-white/20' }} 
                            p-2.5 rounded-lg transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <span>Tableau de bord</span>
                        @if(request()->routeIs('client.dashboard'))
                            <span class="ml-auto bg-white/30 py-0.5 px-2 rounded-md text-xs font-medium shadow-sm">Actif</span>
                        @endif
                    </a>
                    
                    <!-- Mes réservations mobile -->
                    <a href="{{ route('client.reservations.index') }}" class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300
                        {{ request()->routeIs('client.reservations*') ? 'bg-white/20 text-white shadow-lg' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        
                        @if(request()->routeIs('client.reservations*'))
                            <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-white rounded-r-full shadow-md"></span>
                        @endif
                        
                        <div class="mr-3 flex-shrink-0
                            {{ request()->routeIs('client.reservations*') ? 'bg-white/30 shadow-lg' : 'bg-white/10 group-hover:bg-white/20' }} 
                            p-2.5 rounded-lg transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span>Mes réservations</span>
                        @if(isset($ongoingReservations) && $ongoingReservations > 0)
                            <span class="ml-auto bg-blue-400/50 py-0.5 px-2 rounded-md text-xs font-medium shadow-sm animate-pulse">{{ $ongoingReservations }}</span>
                        @endif
                    </a>

                    <!-- État des livraisons -->
                    <a href="{{ route('client.reservations.livraisons') }}" 
                       class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 ease-in-out transform hover:scale-102
                        {{ request()->routeIs('client.reservations.livraisons') ? 'bg-white/20 text-white shadow-lg' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        
                        <!-- Indicateur actif -->
                        @if(request()->routeIs('client.reservations.livraisons'))
                            <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-white rounded-r-full shadow-md"></span>
                        @endif
                        
                        <div class="mr-3 flex-shrink-0 transition-all duration-300 
                            {{ request()->routeIs('client.reservations.livraisons') ? 'bg-white/30 shadow-lg' : 'bg-white/10 group-hover:bg-white/20' }} 
                            p-2.5 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                        <span>État des livraisons</span>
                        @if(isset($pendingDeliveries) && $pendingDeliveries > 0)
                            <span class="ml-auto bg-yellow-400/50 py-0.5 px-2 rounded-md text-xs font-medium shadow-sm animate-pulse">
                                {{ $pendingDeliveries }}
                            </span>
                        @endif
                    </a>
                </nav>
            </div>
            
            <!-- Éléments décoratifs mobile -->
            <div class="px-6 mb-6">
                <div class="bg-gradient-to-r from-blue-900/40 to-indigo-900/40 rounded-xl p-5 backdrop-blur-sm border border-white/10 shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-500/30 rounded-lg mr-4 shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Nouveautés</p>
                            <p class="text-xs text-blue-200 opacity-80">Découvrez nos offres</p>
                        </div>
                    </div>
                    <button class="mt-4 w-full py-2.5 px-3 bg-white/20 hover:bg-white/30 text-white text-sm font-medium rounded-lg transition-all duration-300 shadow-md">
                        Explorer
                    </button>
                </div>
            </div>
            
            <!-- Section statique mobile -->
            <div class="px-6 mt-4">
                <div class="p-4 rounded-xl bg-gradient-to-r from-indigo-900/30 to-blue-900/30 border border-white/10 backdrop-blur-sm shadow-md">
                    <div class="flex items-center mb-3">
                        <div class="p-2 bg-blue-500/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-white">Dernière connexion</p>
                    </div>
                    <p class="text-xs text-blue-200 opacity-80">{{ now()->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
            
            <!-- Déconnexion mobile -->
            <div class="px-6 mt-8 pb-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 bg-white/10 text-white hover:bg-white/20 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content (with padding for sidebar) -->
    <div class="flex-1 flex flex-col overflow-hidden md:ml-64">
        <main class="flex-1 overflow-y-auto p-6">
            @yield('client-content')
        </main>
    </div>
</div>

@push('scripts')
<script>
    // Mobile sidebar toggle functionality avec animation
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const closeSidebar = document.getElementById('close-sidebar');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (sidebarToggle && mobileMenu && closeSidebar) {
            sidebarToggle.addEventListener('click', function() {
                mobileMenu.classList.remove('-translate-x-full');
                mobileMenu.classList.add('translate-x-0');
                document.body.style.overflow = 'hidden'; // Empêche le défilement de la page
            });
            
            closeSidebar.addEventListener('click', function() {
                mobileMenu.classList.remove('translate-x-0');
                mobileMenu.classList.add('-translate-x-full');
                setTimeout(() => {
                    document.body.style.overflow = ''; // Restaure le défilement
                }, 300);
            });
            
            // Ferme le sidebar en cliquant à l'extérieur
            mobileMenu.addEventListener('click', function(event) {
                if (event.target === mobileMenu) {
                    mobileMenu.classList.remove('translate-x-0');
                    mobileMenu.classList.add('-translate-x-full');
                    setTimeout(() => {
                        document.body.style.overflow = '';
                    }, 300);
                }
            });
        }
        
        // Animation pour les liens du menu
        const menuLinks = document.querySelectorAll('nav a');
        menuLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.classList.add('scale-102');
            });
            
            link.addEventListener('mouseleave', function() {
                this.classList.remove('scale-102');
            });
        });
    });
</script>
@endpush
@endsection
@extends('client.dashboard')

@section('client-content')
<div class="min-h-full">
    <!-- Main Content -->
    <div class="md:pl-64 flex flex-col flex-1">
        <main class="flex-1 p-6">
            <!-- Bienvenue Section avec Animation et Citation (conservé comme demandé) -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg mb-8 overflow-hidden relative">
                <div class="absolute inset-0 bg-pattern opacity-10"></div>
                <div class="relative z-10 p-8">
                    <div class="flex items-center animate-fadeIn">
                        <div class="mr-5">
                            <svg class="w-14 h-14 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white tracking-tight">Bienvenue, {{ auth()->user()->prenom }}!</h1>
                            <p class="text-blue-100 mt-1 max-w-2xl">{{ now()->format('l, d F Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 animate-slideUp" style="animation-delay: 0.2s">
                        <blockquote class="italic text-white text-lg">
                            "Le partage d'objets n'est pas seulement une façon de vivre plus économiquement, c'est aussi une façon de vivre plus intensément - en connectant des personnes et créant des communautés."
                        </blockquote>
                        <p class="text-right text-blue-100 mt-2">- L'équipe de MediaRent</p>
                    </div>
                </div>
                
                <!-- Décoration de fond -->
                <div class="absolute -bottom-8 -right-8 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -top-16 -left-16 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl"></div>
            </div>
            
            <!-- Nouvelles cartes statiques bien designées -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Carte 1: Explorer le catalogue -->
                <div class="relative group overflow-hidden rounded-3xl shadow-xl transition-all duration-500 hover:shadow-2xl border border-gray-100 dark:border-gray-800">
                    <!-- Fond avec effet de morphing -->
                    <div class="absolute inset-0 bg-gradient-to-br from-violet-500 to-fuchsia-500 opacity-90 transition-all duration-700 group-hover:scale-110 group-hover:opacity-100"></div>
                    
                    <!-- Motif de fond -->
                    <div class="absolute inset-0 bg-grid-pattern opacity-20 mix-blend-overlay"></div>
                    
                    <!-- Élément de décoration -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-2xl -mr-16 -mt-16 transform rotate-12"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-violet-800/20 rounded-full blur-3xl -ml-10 -mb-10"></div>
                    
                    <div class="relative z-10 p-8 md:p-10 h-full flex flex-col justify-between">
                        <div>
                            <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-lg flex items-center justify-center mb-6 shadow-lg border border-white/20">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            
                            <h2 class="text-2xl font-bold text-white mb-3 tracking-tight">Explorez Notre Collection</h2>
                            <p class="text-purple-50 opacity-90 mb-6 max-w-md">Découvrez notre catalogue diversifié d'objets disponibles à la location. Trouvez exactement ce dont vous avez besoin pour votre prochain projet ou événement.</p>
                        </div>
                        
                        <a href="{{ route('annonces.index') }}" class="group-hover:bg-white/95 inline-flex items-center px-6 py-3 rounded-full text-white group-hover:text-violet-600 bg-white/20 backdrop-blur-md border border-white/25 font-medium transition-all duration-300 text-sm shadow-md hover:shadow-xl w-fit">
    <span>Parcourir mes annonces </span>
    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
    </svg>
</a>
                    </div>
                    
                    <!-- Élément décoratif animé -->
                    <div class="absolute right-8 bottom-8 opacity-70 group-hover:opacity-90 transition-all duration-500 group-hover:scale-110">
                        <svg class="w-24 h-24 text-white/20" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M39.5 71.5Q25 91 29.5 111.5T54 143.5T97.5 168T148 147T169.5 107T147 65T115.5 36T74 40.5T39.5 71.5Z" fill="currentColor"></path>
                        </svg>
                    </div>
                </div>

                <!-- Carte 2: Assistant de Réservation -->
                <div class="relative group overflow-hidden rounded-3xl shadow-xl transition-all duration-500 hover:shadow-2xl border border-gray-100 dark:border-gray-800">
                    <!-- Fond avec effet de morphing -->
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-500 opacity-90 transition-all duration-700 group-hover:scale-110 group-hover:opacity-100"></div>
                    
                    <!-- Motif de fond -->
                    <div class="absolute inset-0 bg-dot-pattern opacity-20 mix-blend-overlay"></div>
                    
                    <!-- Élément de décoration -->
                    <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-2xl -ml-16 -mt-16"></div>
                    <div class="absolute bottom-0 right-0 w-48 h-48 bg-teal-800/20 rounded-full blur-3xl -mr-10 -mb-10"></div>
                    
                    <div class="relative z-10 p-8 md:p-10 h-full flex flex-col justify-between">
                        <div>
                            <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-lg flex items-center justify-center mb-6 shadow-lg border border-white/20">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            
                            <h2 class="text-2xl font-bold text-white mb-3 tracking-tight">Gestion mes réservations</h2>
                            <p class="text-green-50 opacity-90 mb-6 max-w-md">Gérez toutes vos locations en un seul endroit. Visualisez l'historique, suivez les réservations en cours et préparez vos prochaines aventures.</p>
                        </div>
                        
                        <a href="{{ route('client.reservations.index') }}" class="group-hover:bg-white/95 inline-flex items-center px-6 py-3 rounded-full text-white group-hover:text-emerald-600 bg-white/20 backdrop-blur-md border border-white/25 font-medium transition-all duration-300 text-sm shadow-md hover:shadow-xl w-fit">
    <span>Parcourir mes reservations</span>
    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
    </svg>
</a>

                    </div>
                    
                    <!-- Élément décoratif animé -->
                    <div class="absolute right-8 bottom-8 opacity-70 group-hover:opacity-90 transition-all duration-500 group-hover:scale-110">
                        <svg class="w-24 h-24 text-white/20" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M42 66Q20 82 21.5 112.5T46 158.5T89 171T134 159.5T156.5 115T137 58.5T98 33.5T60.5 42.5T42 66Z" fill="currentColor"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@push('styles')
<style>
    .bg-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .bg-grid-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.2' fill-rule='evenodd'%3E%3Cpath d='M0 0h40v40H0V0zm1 1v38h38V1H1z'/%3E%3C/g%3E%3C/svg%3E");
    }
    
    .bg-dot-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.2' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E");
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out forwards;
    }
    
    .animate-slideUp {
        animation: slideUp 0.8s ease-out forwards;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation au survol des cartes
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = (y - centerY) / 20;
                const rotateY = (centerX - x) / 20;
                
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });
            
            card.addEventListener('mouseleave', function() {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
            });
        });
    });
</script>
@endpush
@endsection
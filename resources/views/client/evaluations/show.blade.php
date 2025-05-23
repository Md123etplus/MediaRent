@extends('client.dashboard')

@section('client-content')
<div class="dashboard-card">
    <!-- En-tête moderne avec effet de profondeur et style amélioré -->
    <div class="relative mb-10">
        <!-- Effet de fond avec dégradé amélioré et animation subtile -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/30 to-purple-600/20 rounded-3xl blur-xl transform -rotate-1 hover:rotate-0 transition-transform duration-700"></div>
        
        <!-- Carte principale avec effet glassmorphism -->
        <div class="relative bg-white/90 dark:bg-gray-800/90 rounded-3xl shadow-xl p-8 border border-gray-100/60 dark:border-gray-700/60 backdrop-blur-md transition-all duration-300 hover:shadow-2xl">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <!-- Section titre avec animation au survol -->
                <div class="group">
                    <h2 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600 dark:from-blue-400 dark:via-indigo-300 dark:to-purple-400 transition-all duration-300 group-hover:tracking-wide">Détails de l'évaluation</h2>
                    <div class="h-1 w-24 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mt-2 transition-all duration-300 group-hover:w-full"></div>
                    <p class="text-gray-600 dark:text-gray-300 mt-3 font-medium">Évaluation pour la réservation #{{ $evaluation->reservation_id }}</p>
                </div>
                
                <!-- Bouton retour avec animation améliorée -->
                <a href="{{ route('client.reservations.index') }}" class="group flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 dark:from-blue-500 dark:to-indigo-500 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="font-medium">Retour aux réservations</span>
                </a>
            </div>
        </div>
    </div>
</div>

    <!-- Carte principale avec design moderne et élégant -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 transform transition-all duration-500 hover:translate-y-[-5px]">
        <!-- Section des détails de réservation -->
        <div class="relative overflow-hidden">
            <!-- Éléments décoratifs -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-400/10 to-indigo-500/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-indigo-400/10 to-purple-500/10 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4"></div>
            
            <div class="p-8 relative z-10">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 text-white shadow-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    Détails de la réservation
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Carte période de location -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-750 dark:to-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-blue-100/50 dark:border-blue-800/20 overflow-hidden relative group">
                        <!-- Effet au survol -->
                        <div class="absolute inset-0 bg-blue-500/5 dark:bg-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-500 p-3 rounded-xl shadow-md mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-blue-700 dark:text-blue-300 font-medium text-sm uppercase tracking-wider">Période de location</span>
                                <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg mt-1">
                                    @if($evaluation->reservation->date_debut && $evaluation->reservation->date_fin)
                                        {{ \Carbon\Carbon::parse($evaluation->reservation->date_debut)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($evaluation->reservation->date_fin)->format('d/m/Y') }}
                                    @else
                                        Dates non spécifiées
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Carte date d'évaluation -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-750 dark:to-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-indigo-100/50 dark:border-indigo-800/20 overflow-hidden relative group">
                        <!-- Effet au survol -->
                        <div class="absolute inset-0 bg-indigo-500/5 dark:bg-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-gradient-to-br from-indigo-500 to-purple-500 p-3 rounded-xl shadow-md mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-indigo-700 dark:text-indigo-300 font-medium text-sm uppercase tracking-wider">Date de l'évaluation</span>
                                <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg mt-1">
                                    {{ \Carbon\Carbon::parse($evaluation->created_at)->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Séparateur élégant avec animation -->
        <div class="flex items-center justify-center py-6">
            <div class="w-2/3 h-px bg-gradient-to-r from-transparent via-blue-200 dark:via-blue-700 to-transparent relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/0 via-blue-500/30 dark:via-blue-400/30 to-blue-500/0 animate-pulse"></div>
            </div>
        </div>

        <!-- Section des évaluations avec design amélioré -->
        <div class="px-8 pb-8 space-y-10">
            <!-- Évaluation de l'objet -->
            <div class="group relative transform transition-all duration-500">
                <!-- Arrière-plan avec effet de profondeur -->
                <div class="absolute -inset-4 bg-gradient-to-r from-yellow-500/5 to-amber-500/5 dark:from-yellow-400/10 dark:to-amber-400/10 rounded-3xl opacity-0 group-hover:opacity-100 blur-xl transition-all duration-500"></div>
                
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-yellow-100 dark:border-yellow-800/30 p-6 group-hover:shadow-lg transition-all duration-500 overflow-hidden">
                    <!-- Élément décoratif -->
                    <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-400/10 dark:bg-yellow-400/5 rounded-full -mt-10 -mr-10"></div>
                    <div class="absolute bottom-0 right-0 w-16 h-16 bg-yellow-300/10 dark:bg-yellow-300/5 rounded-full -mb-8 -mr-8"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0 relative z-10 mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-yellow-400 to-amber-500 p-3 rounded-xl shadow-md mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg">Évaluation de l'objet</h4>
                        </div>
                        
                        <div class="flex items-center space-x-1 px-4 py-2 bg-gradient-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/20 dark:to-amber-900/20 rounded-xl shadow-sm border border-yellow-200/50 dark:border-yellow-700/20">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $evaluation->note ? 'text-yellow-400 drop-shadow-sm' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 font-bold text-yellow-600 dark:text-yellow-400">{{ $evaluation->note }}/5</span>
                        </div>
                    </div>
                    
                    <div class="relative bg-gradient-to-br from-yellow-50 to-amber-50 dark:from-yellow-900/10 dark:to-amber-900/10 p-6 rounded-xl border border-yellow-100/50 dark:border-yellow-800/20 shadow-sm">
                        <div class="absolute -left-1 top-0 bottom-0 w-1 bg-gradient-to-b from-yellow-400 to-amber-500 rounded-full"></div>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-200 dark:text-yellow-700/30 absolute top-0 left-0 transform -translate-x-3 -translate-y-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="text-gray-800 dark:text-gray-200 italic pl-8 ml-2">{{ $evaluation->commentaire }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Évaluation du propriétaire -->
            <div class="group relative transform transition-all duration-500">
                <!-- Arrière-plan avec effet de profondeur -->
                <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/5 to-indigo-500/5 dark:from-blue-400/10 dark:to-indigo-400/10 rounded-3xl opacity-0 group-hover:opacity-100 blur-xl transition-all duration-500"></div>
                
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-blue-100 dark:border-blue-800/30 p-6 group-hover:shadow-lg transition-all duration-500 overflow-hidden">
                    <!-- Élément décoratif -->
                    <div class="absolute top-0 right-0 w-20 h-20 bg-blue-400/10 dark:bg-blue-400/5 rounded-full -mt-10 -mr-10"></div>
                    <div class="absolute bottom-0 right-0 w-16 h-16 bg-indigo-300/10 dark:bg-indigo-300/5 rounded-full -mb-8 -mr-8"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0 relative z-10 mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-blue-400 to-indigo-500 p-3 rounded-xl shadow-md mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg">Évaluation du propriétaire</h4>
                        </div>
                        
                        <div class="flex items-center space-x-1 px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl shadow-sm border border-blue-200/50 dark:border-blue-700/20">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $evaluation->note ? 'text-blue-500 drop-shadow-sm' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 font-bold text-blue-600 dark:text-blue-400">{{ $evaluation->note }}/5</span>
                        </div>
                    </div>
                    
                    <div class="relative bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10 p-6 rounded-xl border border-blue-100/50 dark:border-blue-800/20 shadow-sm">
                        <div class="absolute -left-1 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-400 to-indigo-500 rounded-full"></div>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-200 dark:text-blue-700/30 absolute top-0 left-0 transform -translate-x-3 -translate-y-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="text-gray-800 dark:text-gray-200 italic pl-8 ml-2">{{ $evaluation->commentaire }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
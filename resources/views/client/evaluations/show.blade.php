@extends('client.dashboard')

@section('client-content')
<div class="dashboard-card">
    <!-- En-tête avec effet visuel -->
    <div class="relative mb-10">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg opacity-10"></div>
        <div class="relative p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="dashboard-card-header text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-300">Détails de l'évaluation</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Évaluation pour la réservation #{{ $evaluation->reservation_id }}</p>
                </div>
                <a href="{{ route('client.reservations.index') }}" class="flex items-center px-4 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 rounded-full shadow-sm hover:shadow-md transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à mes réservations
                </a>
            </div>
        </div>
    </div>

    <!-- Carte principale avec design moderne -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transform transition-all duration-300 hover:translate-y-[-4px] hover:shadow-xl">
        <!-- Info réservation avec design créatif -->
        <div class="relative">
            <!-- Élément décoratif -->
            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-400 to-indigo-500 opacity-10 rounded-bl-full transform rotate-12"></div>
            
            <div class="p-8 relative z-10">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    Détails de la réservation
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-750 rounded-xl p-5 border-l-4 border-blue-500 shadow-sm">
                        <p class="text-gray-600 dark:text-gray-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-500 dark:text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>
                                <span class="font-medium block text-sm text-gray-500 dark:text-gray-400">Période de location</span>
                                <span class="text-gray-800 dark:text-gray-200 font-medium">
                                    @if($evaluation->reservation->date_debut && $evaluation->reservation->date_fin)
                                        {{ \Carbon\Carbon::parse($evaluation->reservation->date_debut)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($evaluation->reservation->date_fin)->format('d/m/Y') }}
                                    @else
                                        Dates non spécifiées
                                    @endif
                                </span>
                            </span>
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-750 rounded-xl p-5 border-l-4 border-indigo-500 shadow-sm">
                        <p class="text-gray-600 dark:text-gray-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-indigo-500 dark:text-indigo-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>
                                <span class="font-medium block text-sm text-gray-500 dark:text-gray-400">Date de l'évaluation</span>
                                <span class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ \Carbon\Carbon::parse($evaluation->created_at)->format('d/m/Y à H:i') }}
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Séparateur moderne -->
        <div class="flex items-center justify-center py-4">
            <div class="w-1/3 h-0.5 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent"></div>
        </div>

        <!-- Détails évaluation avec design créatif -->
        <div class="p-8 space-y-8">
            <!-- Note objet -->
            <div class="relative group">
                <!-- Élément décoratif -->
                <div class="absolute top-0 left-0 w-full h-full bg-yellow-50 dark:bg-yellow-900/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 group-hover:shadow-md z-10">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <h4 class="font-bold text-gray-900 dark:text-white flex items-center text-lg mb-4 md:mb-0">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </span>
                            Évaluation de l'objet
                        </h4>
                        
                        <div class="flex items-center bg-yellow-50 dark:bg-yellow-900/30 px-4 py-2 rounded-full">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $evaluation->note_objet ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-3 font-bold text-yellow-600 dark:text-yellow-400">{{ $evaluation->note_objet }}/5</span>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-yellow-400 to-yellow-600 rounded-full"></div>
                        <div class="bg-gray-50 dark:bg-gray-750 p-5 rounded-lg pl-6">
                            <svg class="w-8 h-8 text-yellow-200 dark:text-yellow-900 absolute top-3 left-6 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-10zm-10 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.999v10h-9.999z"/>
                            </svg>
                            <p class="text-gray-800 dark:text-gray-200 italic relative z-10 pl-6">{{ $evaluation->commentaire_objet }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Note propriétaire -->
            <div class="relative group">
                <!-- Élément décoratif -->
                <div class="absolute top-0 left-0 w-full h-full bg-blue-50 dark:bg-blue-900/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 group-hover:shadow-md z-10">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <h4 class="font-bold text-gray-900 dark:text-white flex items-center text-lg mb-4 md:mb-0">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            Évaluation du propriétaire
                        </h4>
                        
                        <div class="flex items-center bg-blue-50 dark:bg-blue-900/30 px-4 py-2 rounded-full">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $evaluation->note_proprietaire ? 'text-blue-500' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-3 font-bold text-blue-600 dark:text-blue-400">{{ $evaluation->note_proprietaire }}/5</span>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-400 to-blue-600 rounded-full"></div>
                        <div class="bg-gray-50 dark:bg-gray-750 p-5 rounded-lg pl-6">
                            <svg class="w-8 h-8 text-blue-200 dark:text-blue-900 absolute top-3 left-6 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-10zm-10 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.999v10h-9.999z"/>
                            </svg>
                            <p class="text-gray-800 dark:text-gray-200 italic relative z-10 pl-6">{{ $evaluation->commentaire_proprietaire }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
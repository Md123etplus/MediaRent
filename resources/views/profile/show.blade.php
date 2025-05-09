@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900 dark:border-green-600 dark:text-green-200">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 p-1.5 inline-flex items-center justify-center h-8 w-8 text-green-700 dark:text-green-200 hover:text-green-900 dark:hover:text-green-100 focus:outline-none focus:ring-2 focus:ring-green-400" onclick="this.parentElement.parentElement.style.display='none'">
                        <span class="sr-only">Fermer</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8">
            <div class="flex items-center gap-4">
                <!-- Profile Picture -->
                <div class="relative">
                    @if($user->img_profil)
                        <img src="{{ Storage::url($user->img_profil) }}" alt="Profile Photo" 
                             class="h-24 w-24 rounded-full object-cover border-4 border-blue-500 dark:border-blue-600">
                    @else
                        <div class="h-24 w-24 rounded-full bg-blue-500 flex items-center justify-center text-white text-4xl font-bold border-4 border-blue-600 dark:border-blue-700">
                            {{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->nom, 0, 1)) }}
                        </div>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="absolute -bottom-2 -right-2 bg-white dark:bg-gray-800 p-2 rounded-full shadow-md border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                </div>
                
                <!-- User Info -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $user->prenom }} {{ $user->nom }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $user->role === 'partenaire' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>
            
            <!-- Account Status -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                <h3 class="font-medium text-gray-900 dark:text-white mb-2">Statut du compte</h3>
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full {{ $user->is_suspended ? 'bg-red-500' : 'bg-green-500' }}"></span>
                    <span class="text-sm {{ $user->is_suspended ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                        {{ $user->is_suspended ? 'Suspendu' : 'Actif' }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    Membre depuis {{ $user->created_at->format('d/m/Y') }}
                </p>
            </div>
        </div>
        
        <!-- Main Profile Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Personal Information -->
            <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Informations personnelles
                    </h2>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nom</p>
                            <p class="text-gray-900 dark:text-white">{{ $user->nom }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Prénom</p>
                            <p class="text-gray-900 dark:text-white">{{ $user->prenom }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="text-gray-900 dark:text-white">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">CIN</p>
                            <p class="text-gray-900 dark:text-white">{{ $user->CIN }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Modifier le profil
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- CIN Documents -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Carte d'identité nationale
                    </h2>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <!-- CIN Front -->
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Recto</p>
                        @if($user->img_cin_front)
                            <a href="{{ Storage::url($user->img_cin_front) }}" target="_blank" class="block">
                                <img src="{{ Storage::url($user->img_cin_front) }}" alt="CIN Recto" class="w-full h-auto rounded border border-gray-200 dark:border-gray-700">
                            </a>
                        @else
                            <div class="flex items-center justify-center h-32 bg-gray-100 dark:bg-gray-700 rounded border border-dashed border-gray-300 dark:border-gray-600">
                                <span class="text-gray-500 dark:text-gray-400">Aucune image</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- CIN Back -->
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Verso</p>
                        @if($user->img_cin_back)
                            <a href="{{ Storage::url($user->img_cin_back) }}" target="_blank" class="block">
                                <img src="{{ Storage::url($user->img_cin_back) }}" alt="CIN Verso" class="w-full h-auto rounded border border-gray-200 dark:border-gray-700">
                            </a>
                        @else
                            <div class="flex items-center justify-center h-32 bg-gray-100 dark:bg-gray-700 rounded border border-dashed border-gray-300 dark:border-gray-600">
                                <span class="text-gray-500 dark:text-gray-400">Aucune image</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="pt-2">
                        <a href="{{ route('profile.edit') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            Mettre à jour les documents
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
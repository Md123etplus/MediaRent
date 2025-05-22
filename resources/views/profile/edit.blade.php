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

        <!-- Header with back button -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Modifier le profil</h1>
            <a href="{{ route('profile.show') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 flex items-center gap-1">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Form Column -->
            <div class="md:col-span-2 space-y-6">
                <!-- Basic Information Form -->
                <form method="POST" action="{{ route('profile.update') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
                    @csrf
                    @method('PUT')
                    
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Informations de base
                        </h2>
                    </div>
                    
                    <div class="px-6 py-4 space-y-4">
                        <!-- First Name -->
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prénom</label>
                            <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('prenom')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Last Name -->
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
                            <input type="text" id="nom" name="nom" value="{{ old('nom', $user->nom) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!--username-->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom d'utilisateur</label>
                            <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('username')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- CIN -->
                        <div>
                            <label for="CIN" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Numéro CIN</label>
                            <input type="text" id="CIN" name="CIN" value="{{ old('CIN', $user->CIN) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('CIN')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Password Update Form -->
                <form method="POST" action="{{ route('profile.update-password') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
                    @csrf
                    
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Changer le mot de passe
                        </h2>
                    </div>
                    
                    <div class="px-6 py-4 space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mot de passe actuel</label>
                            <input type="password" id="current_password" name="current_password"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nouveau mot de passe</label>
                            <input type="password" id="password" name="password"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmer le nouveau mot de passe</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Mettre à jour le mot de passe
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Images Column -->
            <div class="space-y-6">
                <!-- Profile Picture Form -->
                <form method="POST" action="{{ route('profile.update-images') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
                    @csrf
                    
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Photo de profil
                        </h2>
                    </div>
                    
                    <div class="px-6 py-4 space-y-4">
                        <!-- Current Profile Picture -->
                        <div class="flex flex-col items-center">
                            @if($user->img_profil)
                                <img src="{{ Storage::url($user->img_profil) }}" alt="Current Profile" class="h-32 w-32 rounded-full object-cover mb-4 border-2 border-blue-500 dark:border-blue-600">
                            @else
                                <div class="h-32 w-32 rounded-full bg-blue-500 flex items-center justify-center text-white text-5xl font-bold mb-4 border-2 border-blue-600 dark:border-blue-700">
                                    {{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->nom, 0, 1)) }}
                                </div>
                            @endif
                            
                            <!-- File Input -->
                            <div class="w-full">
                                <label for="img_profil" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-center">Changer la photo</label>
                                <input type="file" id="img_profil" name="img_profil" accept="image/*"
                                       class="block w-full text-sm text-gray-500 dark:text-gray-400
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900 dark:file:text-blue-200
                                              hover:file:bg-blue-100 dark:hover:file:bg-blue-800">
                                @error('img_profil')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 text-center">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Mettre à jour la photo
                            </button>
                        </div>
                    </div>
                </form>

                <!-- CIN Documents Form -->
                <form method="POST" action="{{ route('profile.update-images') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
                    @csrf
                    
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Documents CIN
                        </h2>
                    </div>
                    
                    <div class="px-6 py-4 space-y-4">
                        <!-- CIN Front -->
                        <div>
                            <label for="img_cin_front" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Recto</label>
                            @if($user->img_cin_front)
                                <a href="{{ Storage::url($user->img_cin_front) }}" target="_blank" class="block mb-2">
                                    <img src="{{ Storage::url($user->img_cin_front) }}" alt="CIN Recto" class="w-full h-auto rounded border border-gray-200 dark:border-gray-700">
                                </a>
                            @endif
                            <input type="file" id="img_cin_front" name="img_cin_front" accept="image/*"
                                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900 dark:file:text-blue-200
                                          hover:file:bg-blue-100 dark:hover:file:bg-blue-800">
                            @error('img_cin_front')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- CIN Back -->
                        <div>
                            <label for="img_cin_back" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Verso</label>
                            @if($user->img_cin_back)
                                <a href="{{ Storage::url($user->img_cin_back) }}" target="_blank" class="block mb-2">
                                    <img src="{{ Storage::url($user->img_cin_back) }}" alt="CIN Verso" class="w-full h-auto rounded border border-gray-200 dark:border-gray-700">
                                </a>
                            @endif
                            <input type="file" id="img_cin_back" name="img_cin_back" accept="image/*"
                                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900 dark:file:text-blue-200
                                          hover:file:bg-blue-100 dark:hover:file:bg-blue-800">
                            @error('img_cin_back')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Mettre à jour les documents
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
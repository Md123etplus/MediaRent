@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            @if(isset($annonce) && $annonce)
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Réservation : {{ $annonce->titre }}</h2>
                
                <form method="POST" action="{{ route('reservations.store', $annonce) }}">
                    @csrf

                    <!-- Section Informations Client -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Informations Personnelles</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nom Complet -->
                            <div>
                                <label for="nom_client" class="block text-sm font-medium text-gray-700 mb-1">Nom Complet *</label>
                                <input type="text" id="nom_client" name="nom_client" 
                                       value="{{ auth()->user()->name ?? old('nom_client') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email_client" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" id="email_client" name="email_client" 
                                       value="{{ auth()->user()->email ?? old('email_client') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            
                            <!-- Téléphone -->
                            <div>
                                <label for="telephone_client" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                                <input type="tel" id="telephone_client" name="telephone_client" 
                                       value="{{ old('telephone_client') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>
                    </div>

                    <!-- Section Dates de Réservation -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Dates de Réservation</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Date de Début -->
                            <div>
                                <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date d'arrivée *</label>
                                <input type="date" id="date_debut" name="date_debut" 
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            
                            <!-- Date de Fin -->
                            <div>
                                <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date de départ *</label>
                                <input type="date" id="date_fin" name="date_fin" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>
                        
                        <!-- Affichage du prix par nuit -->
                        <div class="mt-4 text-sm text-gray-600">
                            Prix par nuit : {{ number_format($annonce->prix, 2) }} €
                        </div>
                    </div>

                    <!-- Section Options Supplémentaires -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Options</h3>
                        
                        <!-- Message -->
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message spécial (optionnel)</label>
                            <textarea id="message" name="message" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('message') }}</textarea>
                        </div>
                        
                        <!-- Conditions -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="conditions" name="conditions" type="checkbox" 
                                       class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="conditions" class="font-medium text-gray-700">J'accepte les conditions générales *</label>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de Soumission -->
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-blue-600 py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Confirmer la Réservation
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <p>L'annonce demandée n'est pas disponible ou a été supprimée.</p>
                    <a href="{{ url()->previous() }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">
                        ← Retour à la page précédente
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
{{-- resources/views/reservations/create_step2.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto transform transition-all duration-500 hover:scale-[1.005]">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                <h2 class="text-3xl font-bold text-white text-center">
                    🚀 Finaliser votre réservation
                </h2>
                <p class="mt-2 text-center text-indigo-100">
                    Pour l'annonce <span class="font-semibold text-white">{{-- Récupérer nom de l'annonce --}}</span>
                </p>
            </div>

            <div class="p-8">
                <!-- Dates display with emoji -->
                <div class="mb-8 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-orange-100 shadow-sm">
                    <div class="flex items-center">
                        <span class="text-3xl mr-3">📅</span>
                        <div>
                            <p class="text-sm font-medium text-orange-600">Dates sélectionnées</p>
                            <p class="text-lg font-bold text-gray-800">
                                Du <span class="text-indigo-600">{{ session('reservation_dates.date_debut') }}</span>
                                au <span class="text-indigo-600">{{ session('reservation_dates.date_fin') }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('reservations.storeFull') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Delivery Options -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center">
                            <span class="mr-2">🚚</span> Options de Livraison
                        </h3>

                        <div class="grid grid-cols-1 gap-4">
                            <!-- Pickup Option -->
                            <label class="relative">
                                <input type="radio" name="delivery_option" value="pickup" checked 
                                    class="absolute opacity-0 peer">
                                <div class="p-4 border-2 border-gray-200 rounded-xl transition-all duration-300
                                    peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:shadow-md
                                    hover:shadow-md hover:border-indigo-300 cursor-pointer">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                                            <span class="text-lg">🏃</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">Récupérer sur place</h4>
                                            <p class="text-sm text-gray-600">Venez chercher l'article directement chez le propriétaire</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Delivery Option -->
                            <label class="relative">
                                <input type="radio" name="delivery_option" value="delivery" 
                                    class="absolute opacity-0 peer">
                                <div class="p-4 border-2 border-gray-200 rounded-xl transition-all duration-300
                                    peer-checked:border-purple-500 peer-checked:bg-purple-50 peer-checked:shadow-md
                                    hover:shadow-md hover:border-purple-300 cursor-pointer">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-purple-100 text-purple-600 mr-4">
                                            <span class="text-lg">📦</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">Se faire livrer</h4>
                                            <p class="text-sm text-gray-600">L'article vous sera livré à l'adresse de votre choix</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Delivery Details (hidden by default) -->
                    <div id="delivery_details" class="space-y-6 hidden transition-all duration-500">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100 shadow-sm">
                            <h4 class="font-bold text-blue-600 mb-4 flex items-center">
                                <span class="mr-2">🏠</span> Détails de livraison
                            </h4>

                            <div class="space-y-4">
                                <div>
                                    <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <span class="mr-2">📍</span> Adresse complète
                                    </label>
                                    <textarea name="delivery_address" id="delivery_address" rows="3" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 hover:shadow-sm"></textarea>
                                </div>

                                <div>
                                    <label for="delivery_notes_client" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <span class="mr-2">📝</span> Instructions spéciales
                                    </label>
                                    <textarea name="delivery_notes_client" id="delivery_notes_client" rows="2" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 hover:shadow-sm"
                                        placeholder="Étage, code d'entrée, etc."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full py-4 px-6 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center">
                        <span class="mr-2">✨</span> Confirmer la réservation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deliveryOptionRadios = document.querySelectorAll('input[name="delivery_option"]');
        const deliveryDetailsDiv = document.getElementById('delivery_details');
        
        deliveryOptionRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'delivery') {
                    deliveryDetailsDiv.classList.remove('hidden');
                    deliveryDetailsDiv.classList.add('animate-fadeIn');
                } else {
                    deliveryDetailsDiv.classList.add('hidden');
                }
            });
        });
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>
@endsection
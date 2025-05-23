@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>

<!-- Modal pour la connexion -->
<div id="loginModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Connexion requise</h3>
        <p class="text-gray-600 mb-6">Vous devez être connecté pour effectuer une réservation.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="document.getElementById('loginModal').classList.add('hidden')" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Annuler
            </button>
            <a href="{{ route('login') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Se connecter
            </a>
        </div>
    </div>
</div>

<div class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Choisissez vos dates</h2>
                
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="mb-6">
                    <input type="text" id="datePicker" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg text-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Cliquez pour sélectionner des dates">
                </div>
                
                <form action="{{ route('reservations.store', ['annonce' => $annonce->id]) }}" method="POST" id="reservationForm">
                    @csrf
                    <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
                    <input type="hidden" name="date_debut" id="startDate">
                    <input type="hidden" name="date_fin" id="endDate">
                    
                    <button type="submit" id="submitBtn"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        Confirmer la réservation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(auth()->guest())
        // Gestion des utilisateurs non connectés
        document.getElementById('loginModal').classList.remove('hidden');
        document.getElementById('datePicker').disabled = true;
        document.getElementById('submitBtn').disabled = true;
        
        document.getElementById('reservationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('loginModal').classList.remove('hidden');
        });
    @else
        // Conversion des dates réservées pour Flatpickr
        const reservedDates = @json($reservedPeriods).map(period => {
            return {
                from: new Date(period.from + 'T00:00:00'), 
                to: new Date(period.to + 'T23:59:59')    
            };
        });

        const datePicker = flatpickr("#datePicker", {
            mode: "range",
            minDate: "today",
            locale: "fr",
            disable: reservedDates,
            dateFormat: "Y-m-d",
            onChange: function(selectedDates) {
                if (selectedDates.length === 2) {
                    document.getElementById('startDate').value = selectedDates[0].toISOString().split('T')[0];
                    document.getElementById('endDate').value = selectedDates[1].toISOString().split('T')[0];
                    document.getElementById('submitBtn').disabled = false;
                } else {
                    document.getElementById('submitBtn').disabled = true;
                }
            }
        });

        const form = document.getElementById('reservationForm');
        form.addEventListener('submit', function() {
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML = 'Traitement en cours...';
        });
    @endif
});
</script>
<style>
.flatpickr-calendar {
    width: 100% !important;
    max-width: 320px !important;
    margin-top: 8px !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    border: 1px solid #e5e7eb !important;
    padding: 12px !important;
}

#loginModal {
    transition: opacity 0.3s ease;
}

/* Styles pour le bouton désactivé */
button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endsection
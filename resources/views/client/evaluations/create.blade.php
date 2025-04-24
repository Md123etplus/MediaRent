@extends('client.dashboard')

@section('client-content')
<div class="dashboard-card">
    <h2 class="dashboard-card-header">Évaluer la réservation</h2>
    
    <form action="{{ route('client.evaluations.store', $reservation->id) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Objet details -->
            <div class="dashboard-card">
                <h3 class="text-lg font-semibold mb-4 dark:text-white">Objet loué</h3>
                <div class="flex items-start">
                    <img src="{{ $reservation->annonce->objet->images->first()->url ?? '/images/placeholder.png' }}" 
                         alt="{{ $reservation->annonce->objet->nom }}" 
                         class="w-24 h-24 rounded-lg object-cover mr-4">
                    <div>
                        <h4 class="text-xl font-bold">{{ $reservation->annonce->objet->nom }}</h4>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $reservation->annonce->objet->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Propriétaire details -->
            <div class="dashboard-card">
                <h3 class="text-lg font-semibold mb-4 dark:text-white">Propriétaire</h3>
                <div class="flex items-start">
                    <img src="{{ $reservation->annonce->proprietaire->img_profil ?? '/images/default-profile.png' }}" 
                         alt="{{ $reservation->annonce->proprietaire->prenom }}" 
                         class="w-24 h-24 rounded-full object-cover mr-4">
                    <div>
                        <h4 class="text-xl font-bold">{{ $reservation->annonce->proprietaire->prenom }} {{ $reservation->annonce->proprietaire->nom }}</h4>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $reservation->annonce->proprietaire->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluation form -->
        <div class="space-y-6">
            <!-- Note for object -->
            <div class="dashboard-card">
                <h3 class="text-lg font-semibold mb-4 dark:text-white">Notez l'objet</h3>
                <div class="rating-stars flex justify-center mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        <input type="radio" id="objet-star{{ $i }}" name="note_objet" value="{{ $i }}" class="hidden" {{ $i == 3 ? 'checked' : '' }}>
                        <label for="objet-star{{ $i }}" class="cursor-pointer">
                            <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </label>
                    @endfor
                </div>
                <textarea name="commentaire_objet" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Donnez votre avis sur l'objet..."></textarea>
            </div>

            <!-- Note for owner -->
            <div class="dashboard-card">
                <h3 class="text-lg font-semibold mb-4 dark:text-white">Notez le propriétaire</h3>
                <div class="rating-stars flex justify-center mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        <input type="radio" id="proprietaire-star{{ $i }}" name="note_proprietaire" value="{{ $i }}" class="hidden" {{ $i == 3 ? 'checked' : '' }}>
                        <label for="proprietaire-star{{ $i }}" class="cursor-pointer">
                            <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </label>
                    @endfor
                </div>
                <textarea name="commentaire_proprietaire" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Donnez votre avis sur le propriétaire..."></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Envoyer l'évaluation
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Rating stars for object
        const objetStars = document.querySelectorAll('.rating-stars input[name="note_objet"]');
        objetStars.forEach(star => {
            star.addEventListener('change', function() {
                const value = parseInt(this.value);
                for (let i = 1; i <= 5; i++) {
                    const label = document.querySelector(`label[for="objet-star${i}"] svg`);
                    if (i <= value) {
                        label.classList.add('text-yellow-400');
                        label.classList.remove('text-gray-300', 'dark:text-gray-600');
                        label.setAttribute('fill', 'currentColor');
                    } else {
                        label.classList.remove('text-yellow-400');
                        label.classList.add('text-gray-300', 'dark:text-gray-600');
                        label.setAttribute('fill', 'none');
                    }
                }
            });
        });

        // Rating stars for owner
        const proprietaireStars = document.querySelectorAll('.rating-stars input[name="note_proprietaire"]');
        proprietaireStars.forEach(star => {
            star.addEventListener('change', function() {
                const value = parseInt(this.value);
                for (let i = 1; i <= 5; i++) {
                    const label = document.querySelector(`label[for="proprietaire-star${i}"] svg`);
                    if (i <= value) {
                        label.classList.add('text-yellow-400');
                        label.classList.remove('text-gray-300', 'dark:text-gray-600');
                        label.setAttribute('fill', 'currentColor');
                    } else {
                        label.classList.remove('text-yellow-400');
                        label.classList.add('text-gray-300', 'dark:text-gray-600');
                        label.setAttribute('fill', 'none');
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection
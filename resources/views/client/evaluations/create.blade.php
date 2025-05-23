@extends('client.dashboard')

@section('client-content')
<div class="container py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Évaluation de la location #{{ $reservation->id }}</h1>
        
        <!-- Détails de la réservation -->
        <div class="mb-8 bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold mb-2">Détails de la location</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Objet loué :</p>
                    <p class="font-medium">{{ $reservation->annonce->objet->nom }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Période :</p>
                    <p class="font-medium">
                        {{ Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }} - 
                        {{ Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('evaluations.store', [$reservation->id, $type]) }}">
            @csrf

            <!-- Section d'évaluation -->
            @if($type === 'client_to_partner')
                <!-- Évaluation du partenaire et de son objet -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Évaluation du partenaire : {{ $reservation->annonce->proprietaire->prenom }} {{ $reservation->annonce->proprietaire->nom }}</h2>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 mb-2">Note du partenaire (1 à 5 étoiles)</label>
                        <div class="flex space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="note_partenaire" value="{{ $i }}" id="note-partenaire-{{ $i }}" 
                                       class="hidden peer" {{ old('note_partenaire') == $i ? 'checked' : '' }}>
                                <label for="note-partenaire-{{ $i }}" 
                                       class="text-3xl cursor-pointer peer-checked:text-yellow-400">★</label>
                            @endfor
                        </div>
                        @error('note_partenaire')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="commentaire_partenaire" class="block text-gray-700 mb-2">Commentaire sur le partenaire</label>
                        <textarea name="commentaire_partenaire" id="commentaire_partenaire" rows="3"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Comment s'est passée votre interaction avec le partenaire ?">{{ old('commentaire_partenaire') }}</textarea>
                        @error('commentaire_partenaire')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 mb-2">Note de l'objet (1 à 5 étoiles)</label>
                        <div class="flex space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="note_objet" value="{{ $i }}" id="note-objet-{{ $i }}" 
                                       class="hidden peer" {{ old('note_objet') == $i ? 'checked' : '' }}>
                                <label for="note-objet-{{ $i }}" 
                                       class="text-3xl cursor-pointer peer-checked:text-yellow-400">★</label>
                            @endfor
                        </div>
                        @error('note_objet')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="commentaire_objet" class="block text-gray-700 mb-2">Commentaire sur l'objet</label>
                        <textarea name="commentaire_objet" id="commentaire_objet" rows="3"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Comment était l'état de l'objet ?">{{ old('commentaire_objet') }}</textarea>
                        @error('commentaire_objet')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @else
                <!-- Évaluation du client -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Évaluation du client : {{ $reservation->client->prenom }} {{ $reservation->client->nom }}</h2>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 mb-2">Note du client (1 à 5 étoiles)</label>
                        <div class="flex space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="note_client" value="{{ $i }}" id="note-client-{{ $i }}" 
                                       class="hidden peer" {{ old('note_client') == $i ? 'checked' : '' }}>
                                <label for="note-client-{{ $i }}" 
                                       class="text-3xl cursor-pointer peer-checked:text-yellow-400">★</label>
                            @endfor
                        </div>
                        @error('note_client')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="commentaire_client" class="block text-gray-700 mb-2">Commentaire sur le client</label>
                        <textarea name="commentaire_client" id="commentaire_client" rows="3"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Comment s'est passée votre interaction avec le client ?">{{ old('commentaire_client') }}</textarea>
                        @error('commentaire_client')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif

            <button type="submit" 
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition w-full md:w-auto">
                Soumettre l'évaluation
            </button>
        </form>
    </div>
</div>
@endsection
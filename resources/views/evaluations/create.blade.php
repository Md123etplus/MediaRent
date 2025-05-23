@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Évaluation de la location #{{ $reservation->id }}</h1>
        
        <form method="POST" action="{{ route('evaluations.store', [$reservation->id, $type]) }}">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">
                    Note (entre 1 et 5 étoiles)
                </label>
                <div class="flex space-x-2">
                    @for($i = 1; $i <= 5; $i++)
                        <input type="radio" name="note" value="{{ $i }}" id="note-{{ $i }}" 
                               class="hidden peer" {{ old('note') == $i ? 'checked' : '' }}>
                        <label for="note-{{ $i }}" 
                               class="text-3xl cursor-pointer peer-checked:text-yellow-400">★</label>
                    @endfor
                </div>
                @error('note')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="commentaire" class="block text-gray-700 mb-2">
                    Commentaire
                </label>
                <textarea name="commentaire" id="commentaire" rows="5"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>{{ old('commentaire') }}</textarea>
                @error('commentaire')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" 
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Soumettre l'évaluation
            </button>
        </form>
    </div>
</div>
@endsection
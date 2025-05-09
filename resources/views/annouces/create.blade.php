@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Créer une nouvelle annonce</h1>
        
        <form action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="titre" class="block text-gray-700 mb-2">Titre de l'annonce</label>
                <input type="text" name="titre" id="titre" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border rounded-lg" required></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="prix_journalier" class="block text-gray-700 mb-2">Prix journalier (DH)</label>
                    <input type="number" name="prix_journalier" id="prix_journalier" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label for="categorie_id" class="block text-gray-700 mb-2">Catégorie</label>
                    <select name="categorie_id" id="categorie_id" class="w-full px-4 py-2 border rounded-lg" required>
                        @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Ajoutez ici les autres champs nécessaires -->

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    Publier l'annonce
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
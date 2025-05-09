@extends('layouts.app')

@section('title', 'Recherche')
@section('content')
<div class="flex">
    <!-- Filtres -->
    <div class="w-1/4 p-4 bg-white rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Filtrer</h2>
        <form action="{{ route('search.results') }}" method="GET">
            <!-- Champs de filtre -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded">Appliquer</button>
        </form>
    </div>

    <!-- Résultats -->
    <div class="w-3/4 p-4">
        <h1 class="text-2xl font-bold mb-6">Résultats de recherche</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Cartes d'annonces -->
            @foreach($ads as $ad)
                @include('components.ad-card', ['ad' => $ad])
            @endforeach
        </div>
    </div>
</div>
@endsection
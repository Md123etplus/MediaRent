@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">
        Réserver : {{ $annonce->objet->nom }}
    </h2>
    @if(Auth::check())

    <form method="POST" action="{{ route('reservations.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">

        <div>
            <label for="date_debut" class="block font-semibold">Date de début :</label>
            <input id="date_debut" name="date_debut" type="date"
                   class="w-full border rounded p-2" required>
        </div>

        <div>
            <label for="date_fin" class="block font-semibold">Date de fin :</label>
            <input id="date_fin" name="date_fin" type="date"
                   class="w-full border rounded p-2" required>
        </div>

        <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Valider la réservation
        </button>
    </form>
</div>
@else
    <p>Vous devez être connecté pour faire une réservation.</p>
@endif
@endsection

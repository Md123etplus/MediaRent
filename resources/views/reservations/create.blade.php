@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        @isset($annonce)
            <h1 class="text-2xl font-bold mb-6">Réservation : {{ $annonce->titre }}</h1>
            
            <form action="{{ route('reservations.store', ['annonce' => $annonce->id]) }}" method="POST">
    @csrf
    <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">

    <label for="date_debut">Date de début</label>
    <input type="date" name="date_debut" required><br>

    <label for="date_fin">Date de fin</label>
    <input type="date" name="date_fin" required><br>
    <input type="text" name="statut" value="en_attente" hidden><br>
    <button type="submit">Réserver</button>
</form>

        @else
            <div class="text-red-600">
                Cette annonce n'est pas disponible.
                <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline">Retour</a>
            </div>
        @endisset
    </div>
</div>
@endsection
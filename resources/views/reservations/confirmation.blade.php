@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-8">
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-6 rounded">
        <h2 class="text-xl font-bold mb-4">Merci pour votre réservation !</h2>
        <p>Votre demande a été enregistrée avec succès. Vous recevrez un email dès que le propriétaire l’aura confirmée.</p>
        <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Retour à la recherche</a>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">Mes Réservations</h2>

    @if($reservations->isEmpty())
        <p>Aucune réservation pour le moment.</p>
    @else
        <ul class="space-y-4">
            @foreach($reservations as $res)
                <li class="border p-4 rounded">
                    <strong>Objet :</strong> {{ $res->annonce->objet->nom }}<br>
                    <strong>Période :</strong> {{ $res->date_debut }} → {{ $res->date_fin }}<br>
                    <strong>Statut :</strong> {{ $res->statut }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection

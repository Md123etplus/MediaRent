@extends('layouts.app')

@section('content')
<h2>Objets Disponibles</h2>
@foreach($objets as $objet)
    <div>
        <h3>{{ $objet->nom }}</h3>
        <p>{{ $objet->description }}</p>
        <p>Ville : {{ $objet->ville }}</p>
        <a href="{{ route('objets.show', $objet->id) }}">Voir détails</a>
    </div>
@endforeach
@endsection

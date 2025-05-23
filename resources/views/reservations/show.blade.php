@extends('layouts.app')

@section('content')
<h2>Détails de l'Objet</h2>
<h3>{{ $objet->nom }}</h3>
<p>{{ $objet->description }}</p>
<p>Prix/jour : {{ $objet->prix_journalier }} DH</p>
<a href="{{ route('reservations.create', $objet->id) }}">Réserver</a>
@endsection

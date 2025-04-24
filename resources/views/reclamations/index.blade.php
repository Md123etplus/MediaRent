@extends('layouts.app')

@section('content')
<h2>Vos Réclamations</h2>

<form method="POST" action="{{ route('reclamations.store') }}">
    @csrf
    <textarea name="contenu" placeholder="Décrivez votre réclamation..." required></textarea>
    <button type="submit">Envoyer</button>
</form>

@foreach($reclamations as $rec)
    <div>
        <p>{{ $rec->contenu }}</p>
        <p><small>{{ $rec->created_at }}</small></p>
    </div>
@endforeach
@endsection

<!-- resources/views/locations/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Rechercher des locations</h1>
        </div>
        <div class="col-md-4">
            <form action="{{ route('locations.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="ville" class="form-control" placeholder="Ville..." value="{{ request('ville') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Filtres</div>
                <div class="card-body">
                    <form action="{{ route('locations.index') }}" method="GET">
                        <div class="form-group">
                            <label>Catégorie</label>
                            <select name="categorie" class="form-control">
                                <option value="">Toutes</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Prix min</label>
                            <input type="number" name="min_prix" class="form-control" value="{{ request('min_prix') }}">
                        </div>
                        <div class="form-group">
                            <label>Prix max</label>
                            <input type="number" name="max_prix" class="form-control" value="{{ request('max_prix') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Appliquer</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                @foreach($annonces as $annonce)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ $annonce->objet->images->first()->url ?? 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $annonce->objet->nom }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $annonce->objet->nom }}</h5>
                                <p class="card-text">
                                    <i class="fas fa-map-marker-alt"></i> {{ $annonce->objet->ville }}<br>
                                    <i class="fas fa-tag"></i> {{ $annonce->objet->categorie->nom }}<br>
                                    <i class="fas fa-user"></i> {{ $annonce->proprietaire->prenom }} {{ $annonce->proprietaire->nom }}
                                </p>
                                <h4 class="text-primary">{{ $annonce->objet->prix_journalier }} €/jour</h4>
                                @if($annonce->premium)
                                    <span class="badge badge-warning">Premium</span>
                                @endif
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('locations.show', $annonce) }}" class="btn btn-primary btn-block">Voir détails</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{ $annonces->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
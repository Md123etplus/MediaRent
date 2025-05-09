<!-- resources/views/locations/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($location->images as $key => $image)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                <img src="{{ $image->image_path }}" class="d-block w-100" alt="...">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="card-body">
                    <h2 class="card-title">{{ $location->title }}</h2>
                    <p class="card-text">{{ $location->description }}</p>
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="badge badge-primary">{{ $location->category->name }}</span>
                            <span class="badge badge-secondary">{{ $location->city }}</span>
                            @if($location->is_premium)
                                <span class="badge badge-warning">Premium</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $location->rating ? '' : '-empty' }}"></i>
                                @endfor
                                ({{ $location->ratings->count() }})
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">À propos du propriétaire</div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <img src="{{ $location->partner->avatar ?? 'https://via.placeholder.com/50' }}" class="rounded-circle" width="50" height="50" alt="...">
                        </div>
                        <div>
                            <h5>{{ $location->partner->name }}</h5>
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $location->partner->rating ? '' : '-empty' }}"></i>
                                @endfor
                                ({{ $location->partner->ratings_received->count() }} avis)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h4 class="mb-0">{{ $location->price_per_day }} € <small class="text-muted">/ jour</small></h4>
                </div>
                <div class="card-body">
                    @auth
                        <form action="{{ route('locations.reserve', $location) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="start_date">Date de début</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Date de fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <div class="form-group">
                                <label>Option de livraison</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_option" id="pickup" value="pickup" checked>
                                    <label class="form-check-label" for="pickup">
                                        Retrait sur place
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_option" id="delivery" value="delivery">
                                    <label class="form-check-label" for="delivery">
                                        Livraison (+10€)
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Réserver maintenant</button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            Vous devez être connecté pour effectuer une réservation.
                            <a href="{{ route('login') }}" class="alert-link">Se connecter</a> ou
                            <a href="{{ route('register') }}" class="alert-link">S'inscrire</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
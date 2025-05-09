@extends('layouts.app')

@section('content')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 40px;
        font-size: 2.5rem;
        color: #2c3e50;
        font-weight: 700;
        position: relative;
    }

    h1::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: #3498db;
        margin: 15px auto 0;
        border-radius: 2px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .col-md-4 {
        flex: 0 0 calc(33.333% - 20px);
        max-width: calc(33.333% - 20px);
    }

    .card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        background: white;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .card.premium {
        border: 2px solid #FFD700;
        box-shadow: 0 5px 20px rgba(255, 215, 0, 0.3);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .card.premium:hover {
        box-shadow: 0 10px 25px rgba(255, 215, 0, 0.4);
    }

    .card-body {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 1.25rem;
        margin-bottom: 15px;
        color: #2c3e50;
        font-weight: 600;
    }

    .card-text {
        margin-bottom: 10px;
        color: #7f8c8d;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .premium-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #FFD700, #FFA500);
        color: #000;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        z-index: 20;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .carousel-container {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
    }

    .carousel-track {
        display: flex;
        height: 100%;
        transition: transform 0.5s ease;
    }

    .carousel-slide {
        min-width: 100%;
        height: 100%;
    }

    .carousel-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s;
    }

    .carousel-btn:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .carousel-btn.prev {
        left: 10px;
    }

    .carousel-btn.next {
        right: 10px;
    }

    .carousel-btn svg {
        width: 20px;
        height: 20px;
    }

    .no-image {
        width: 100%;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
        color: #999;
    }

    @media (max-width: 992px) {
        .col-md-4 {
            flex: 0 0 calc(50% - 20px);
            max-width: calc(50% - 20px);
        }
    }

    @media (max-width: 768px) {
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 30px;
        }
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #7f8c8d;
        font-size: 1.2rem;
        width: 100%;
    }

   
    
    /* Ajoutez ce nouveau style pour le badge "Active" */
    .status-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: #38a169;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 20;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
</style>

<div class="container">
    <h1>Annonces Actives</h1> <!-- Modifiez le titre pour plus de clarté -->
    
    <div class="row">
        @forelse($annonces as $annonce)
            @if($annonce->statut === 'active') <!-- Double vérification côté vue -->
            <div class="col-md-4 mb-4">
                <div class="card @if($annonce->premium) premium @endif">
                    <!-- Badge Statut -->
                    <span class="status-badge">Active</span>
                    
                    @if($annonce->premium)
                        <div class="premium-badge">Premium</div>
                    @endif
                    
                    <a href="{{ route('annonces.show', $annonce->id) }}" class="card-link" style="text-decoration: none; color: inherit;">
                        <div class="carousel-container" id="carousel-{{ $annonce->id }}">
                            @if($annonce->objet->images->count())
                                <div class="carousel-track">
                                    @foreach($annonce->objet->images as $image)
                                        <div class="carousel-slide">
                                            <img src="{{ asset($image->url) }}" alt="Image {{ $loop->iteration }} de {{ $annonce->objet->nom }}">
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-btn prev" onclick="prevSlide({{ $annonce->id }}, event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>

                                <button class="carousel-btn next" onclick="nextSlide({{ $annonce->id }}, event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            @else
                                <div class="no-image">Image non disponible</div>
                            @endif
                        </div>
                    </a>

                    <div class="card-body">
                        <h5 class="card-title">{{ $annonce->objet->nom }}</h5>
                        
                        <p class="card-text">📍 {{ $annonce->objet->ville }}</p>

                        <p class="card-text">💰 {{ $annonce->objet->prix_journalier }} € / jour</p>

                        <p class="card-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3498db" viewBox="0 0 16 16" style="margin-right: 8px; vertical-align: text-top;">
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                            </svg> 
                            {{ $annonce->date_debut->format('d/m/Y') }} - {{ $annonce->date_fin->format('d/m/Y') }}
                        </p>

                        <p class="card-text">🤝 Par {{ $annonce->proprietaire->full_name ?? 'Non spécifié' }}</p>
                    </div>
                </div>
            </div>
            @endif
        @empty
            <p class="empty-state">Aucune annonce active disponible.</p>
        @endforelse
    </div>
</div>
<script>
    const currentIndices = {};

    function initCarousel(id) {
        if (!currentIndices.hasOwnProperty(id)) {
            currentIndices[id] = 0;
        }
        updateCarousel(id);
    }

    function nextSlide(id, event) {
        event.preventDefault();
        event.stopPropagation();
        const carousel = document.getElementById(`carousel-${id}`);
        const slides = carousel.querySelectorAll('.carousel-slide');
        currentIndices[id] = (currentIndices[id] + 1) % slides.length;
        updateCarousel(id);
    }

    function prevSlide(id, event) {
        event.preventDefault();
        event.stopPropagation();
        const carousel = document.getElementById(`carousel-${id}`);
        const slides = carousel.querySelectorAll('.carousel-slide');
        currentIndices[id] = (currentIndices[id] - 1 + slides.length) % slides.length;
        updateCarousel(id);
    }

    function updateCarousel(id) {
        const carousel = document.getElementById(`carousel-${id}`);
        const track = carousel.querySelector('.carousel-track');
        const slideWidth = 100;
        track.style.transform = `translateX(-${currentIndices[id] * slideWidth}%)`;
    }

    document.addEventListener('DOMContentLoaded', function () {
        @foreach($annonces as $annonce)
            @if($annonce->objet->images->count())
                initCarousel({{ $annonce->id }});
            @endif
        @endforeach
    });
</script>
@endsection
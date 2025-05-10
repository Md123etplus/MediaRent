@extends('layouts.app')

@section('content')
<style>
    .annonces-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-bottom: 40px;
        font-size: 2.2rem;
        color: #2c3e50;
        font-weight: 700;
        position: relative;
    }

    h2::after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
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

    .annonce-card {
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

    .annonce-card:hover {
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
        display: flex;
        align-items: center;
    }

    .card-text {
        margin-bottom: 10px;
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    .card-text strong {
        color: #2c3e50;
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

    .detail-btn {
        align-self: flex-start;
        margin-top: 15px;
        background: #3498db;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .detail-btn:hover {
        background: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 10px 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #7f8c8d;
        font-size: 1.1rem;
        width: 100%;
        background: #f8f9fa;
        border-radius: 8px;
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

        h2 {
            font-size: 1.8rem;
            margin-bottom: 30px;
        }
    }
</style>

<div class="container annonces-container">
    <h2>Mes Annonces</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($annonces->isEmpty())
        <div class="empty-state">
            <p>Vous n'avez pas encore créé d'annonces.</p>
        </div>
    @else
        <div class="row">
            @foreach($annonces as $annonce)
                <div class="col-md-4 mb-4">
                    <div class="annonce-card @if($annonce->premium) premium @endif">
                        @if($annonce->premium)
                            <span class="premium-badge">Premium</span>
                        @endif
                        
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

                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $annonce->objet->nom ?? 'Objet sans nom' }}
                            </h5>
                            <p class="card-text">
                                <strong>Dates:</strong> {{ $annonce->date_debut->format('d/m/Y') }} - {{ $annonce->date_fin->format('d/m/Y') }}
                            </p>
                            <p class="card-text">
                                <strong>Statut:</strong> {{ $annonce->statut }}
                            </p>
                            <p class="card-text">
                                <strong>Adresse:</strong> {{ $annonce->adress }}
                            </p>
                            <a  class="detail-btn">Voir détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
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
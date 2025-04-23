@extends('layouts.app')

@section('content')

<style>
.annonce-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    max-width: 1000px;
    margin: auto;
}

.annonce-left {
    flex: 1 1 40%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.gallery-main {
    width: 100%;
    height: 300px;
    overflow: hidden;
    border-radius: 8px;
    background: #f8f8f8;
    display: flex;
    justify-content: center;
    align-items: center;
}

.gallery-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    display: none;
}

.gallery-image.active {
    display: block;
}

.gallery-thumbnails {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

.thumbnail img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    cursor: pointer;
    border: 2px solid transparent;
}

.thumbnail.active img {
    border-color: #3498db;
}

.annonce-right {
    flex: 1 1 55%;
}

.annonce-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 10px;
}

.annonce-price {
    font-size: 20px;
    color: #27ae60;
    margin-bottom: 15px;
}

.annonce-meta p {
    margin: 4px 0;
    color: #555;
}

.annonce-description h3 {
    margin-top: 20px;
    font-size: 18px;
}

.partner-card {
    background: #f1f1f1;
    padding: 12px 16px;
    border-radius: 10px;
    margin-top: 20px;
}

@media screen and (max-width: 768px) {
    .annonce-wrapper {
        flex-direction: column;
    }

    .annonce-left, .annonce-right {
        flex: 1 1 100%;
    }
}
</style>

<div class="annonce-wrapper">
    <div class="annonce-left">
        <!-- Galerie principale -->
        <div class="gallery-main" id="main-gallery">
            @foreach($annonce->objet->images as $key => $image)
                <img src="{{ asset($image->url ?? '') }}" class="gallery-image {{ $loop->first ? 'active' : '' }}" alt="Photo de {{ $annonce->objet->nom ?? '' }}">
            @endforeach
        </div>

        @if($annonce->objet->images->count() > 1)
            <div class="gallery-thumbnails">
                @foreach($annonce->objet->images as $key => $image)
                    <div class="thumbnail {{ $loop->first ? 'active' : '' }}" data-index="{{ $key }}" onclick="showImage({{ $key }})">
                        <img src="{{ asset($image->url ?? '') }}" alt="Miniature">
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="annonce-right">
        <!-- Titre & prix -->
        <h1 class="annonce-title">{{ $annonce->objet->nom ?? 'Nom non disponible' }}</h1>
        <div class="annonce-price">{{ $annonce->objet->prix_journalier ?? '0' }} € / jour</div>

        <!-- Métadonnées -->
        <div class="annonce-meta">
            <p><strong>Ville :</strong> {{ $annonce->objet->ville ?? 'Ville non spécifiée' }}</p>
            <p><strong>Catégorie :</strong> {{ $annonce->objet->categorie->nom ?? 'Catégorie non définie' }}</p>
            <p><strong>Publié :</strong> {{ $annonce->created_at->diffForHumans() }}</p>
        </div>

        <!-- Description -->
        <div class="annonce-description">
            <h3>Description</h3>
            <p>{{ $annonce->objet->description ?? 'Aucune description disponible' }}</p>
        </div>

        <!-- Propriétaire -->
        <div class="partner-card">
            <h4>{{ $annonce->proprietaire->full_name ?? 'Propriétaire inconnu' }}</h4>
            <p>Membre depuis {{ $annonce->proprietaire->created_at->diffForHumans() ?? 'date inconnue' }}</p>
        </div>
    </div>
</div>

<script>
function showImage(index) {
    const images = document.querySelectorAll('.gallery-image');
    const thumbnails = document.querySelectorAll('.thumbnail');

    images.forEach((img, i) => {
        img.classList.toggle('active', i === index);
    });

    thumbnails.forEach((thumb, i) => {
        thumb.classList.toggle('active', i === index);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const thumbnails = document.querySelectorAll('.thumbnail');
    const imageCount = {{ !empty($annonce->objet->images) && $annonce->objet->images->isNotEmpty() ? $annonce->objet->images->count() : 0 }};

    if (imageCount > 1) {
        let index = 0;
        setInterval(() => {
            index = (index + 1) % imageCount;
            showImage(index);
        }, 1000);
    }
});
</script>

@endsection

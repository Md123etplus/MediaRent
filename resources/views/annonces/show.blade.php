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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
            position: relative;
        }

        .gallery-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: none;
            transition: opacity 0.3s ease;
        }

        .gallery-image.active {
            display: block;
            opacity: 1;
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
            transition: all 0.2s ease;
        }

        .thumbnail.active img {
            border-color: #3498db;
            transform: scale(1.05);
        }

        .thumbnail:hover img {
            transform: scale(1.1);
        }

        .annonce-right {
            flex: 1 1 55%;
            position: relative;
        }

        .annonce-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .annonce-price {
            font-size: 20px;
            color: #27ae60;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .annonce-meta p {
            margin: 8px 0;
            color: #555;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .annonce-meta strong {
            color: #2c3e50;
            min-width: 100px;
            display: inline-block;
        }

        .annonce-description h3 {
            margin-top: 20px;
            font-size: 18px;
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .partner-card {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 10px;
            margin-top: 25px;
            border: 1px solid #eee;
        }

        .partner-card h4 {
            margin: 0 0 8px 0;
            color: #2c3e50;
        }

        .reservation-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11);
        }

        .reservation-btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1);
        }

        .reservation-btn i {
            font-size: 18px;
        }

        @media screen and (max-width: 768px) {
            .annonce-wrapper {
                flex-direction: column;
            }

            .annonce-left,
            .annonce-right {
                flex: 1 1 100%;
            }

            .gallery-main {
                height: 250px;
            }
        }
    </style>


    <div class="annonce-wrapper">
        <div class="annonce-left">
            <!-- Galerie principale -->
            <div class="gallery-main" id="main-gallery">
                @foreach ($annonce->objet->images as $key => $image)
                    <img src="{{ asset($image->url ?? '') }}" class="gallery-image {{ $loop->first ? 'active' : '' }}"
                        alt="Photo de {{ $annonce->objet->nom ?? '' }}">
                @endforeach

                @if ($annonce->premium)
                    <div class="premium-badge"
                        style="position: absolute; top: 15px; right: 15px; background: linear-gradient(135deg, #FFD700, #FFA500); color: #000; padding: 5px 10px; border-radius: 20px; font-weight: bold; z-index: 10;">
                        Premium
                    </div>
                @endif
            </div>

            @if ($annonce->objet->images->count() > 1)
                <div class="gallery-thumbnails">
                    @foreach ($annonce->objet->images as $key => $image)
                        <div class="thumbnail {{ $loop->first ? 'active' : '' }}" data-index="{{ $key }}"
                            onclick="showImage({{ $key }})">
                            <img src="{{ asset($image->url ?? '') }}" alt="Miniature">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="annonce-right">
            <!-- Titre & prix -->
            <h1 class="annonce-title">{{ $annonce->objet->nom ?? 'Nom non disponible' }}</h1>
            <div class="annonce-price">{{ number_format($annonce->objet->prix_journalier ?? 0, 2) }} € / jour</div>

            <!-- Métadonnées -->
            <div class="annonce-meta">
                <p><strong>📍 Ville :</strong> {{ $annonce->objet->ville ?? 'Ville non spécifiée' }}</p>
                <p><strong>🏷 Catégorie :</strong> {{ $annonce->objet->categorie->nom ?? 'Catégorie non définie' }}</p>
                <p><strong>📅 Publié :</strong> {{ $annonce->created_at->diffForHumans() }}</p>
                <p><strong>⭐ Note :</strong>
                    @if ($annonce->objet->moyenne_notes)
                        {{ number_format($annonce->objet->moyenne_notes, 1) }}/5 ({{ $annonce->objet->nombre_avis }} avis)
                    @else
                        Pas encore noté
                    @endif
                </p>

                <!-- Ajouter le bouton Voir la fiche objet -->
                <div class="mt-4">
                    <a href="{{ route('fiches.objet.show', $annonce->objet->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Voir la fiche de l'objet
                    </a>
                </div>
            </div>

            <!-- Description -->
            <div class="annonce-description">
                <h3>Description</h3>
                <p>{{ $annonce->objet->description ?? 'Aucune description disponible' }}</p>
            </div>

            <!-- Bouton de réservation -->
            <form action="{{ route('reservations.create', $annonce->id) }}" method="GET">
                @csrf
                <button type="submit" class="reservation-btn">
                    <i class="fas fa-calendar-check"></i>
                    Réserver maintenant
                </button>
            </form>

            <!-- Bouton "Passer en Premium"  -->
            {{-- DEBUG - À supprimer après diagnostic --}}
            {{-- <div style="background: #f8f8f8; padding: 10px; margin-bottom: 20px;">
                <h4>Debug:</h4>
                <p>Utilisateur connecté: {{ auth()->check() ? 'Oui (ID: ' . auth()->id() . ')' : 'Non' }}</p>
                <p>Propriétaire annonce: {{ $annonce->proprietaire_id }}</p>
                <p>Statut premium: {{ $annonce->premium ? 'Oui' : 'Non' }}</p>
            </div> --}}


            @if (auth()->check() && auth()->id() == $annonce->proprietaire_id)
                @if (!$annonce->premium)
                    <div class="premium-cta-wrapper" style="margin-top: 25px;">
                        <a href="{{ route('annonces.premium', $annonce) }}" class="glowing-premium-btn">
                            <span class="icon-crown">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 16L3 5L8.5 10L12 4L15.5 10L21 5L19 16H5Z" fill="currentColor" />
                                    <path d="M5 16H19V19C19 20.1046 18.1046 21 17 21H7C5.89543 21 5 20.1046 5 19V16Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <span class="btn-text">Boostez en Premium</span>
                            <span class="hover-effect"></span>
                        </a>
                        <div class="sparkle-effect">
                            <div class="sparkle"></div>
                            <div class="sparkle"></div>
                            <div class="sparkle"></div>
                        </div>
                    </div>
                @else
                    <div class="premium-active-badge">
                        <span class="badge-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 16.17L4.83 12L3.41 13.41L9 19L21 7L19.59 5.59L9 16.17Z" fill="currentColor" />
                            </svg>
                        </span>
                        @if ($annonce->premium_expires_at)
                            <span class="badge-text">
                                Premium jusqu'au {{ $annonce->premium_expires_at->format('d/m/Y') }}
                            </span>
                        @endif
                        <div class="active-pulse"></div>
                    </div>
                @endif
            @endif

            <style>
                /* Style principal du bouton */
                .glowing-premium-btn {
                    position: relative;
                    display: inline-flex;
                    align-items: center;
                    gap: 12px;
                    padding: 16px 32px;
                    background: linear-gradient(135deg, #FF6BFF 0%, #A855F7 50%, #6366F1 100%);
                    color: white;
                    font-weight: 600;
                    border-radius: 12px;
                    text-decoration: none;
                    overflow: hidden;
                    z-index: 1;
                    box-shadow: 0 4px 20px rgba(168, 85, 247, 0.4);
                    border: none;
                    cursor: pointer;
                    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                    transform-style: preserve-3d;
                }

                /* Effet de survol */
                .glowing-premium-btn:hover {
                    transform: translateY(-3px) scale(1.02);
                    box-shadow: 0 8px 30px rgba(168, 85, 247, 0.6);
                }

                /* Effet de lumière au survol */
                .hover-effect {
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(90deg,
                            transparent,
                            rgba(255, 255, 255, 0.2),
                            transparent);
                    transition: 0.6s;
                    z-index: -1;
                }

                .glowing-premium-btn:hover .hover-effect {
                    left: 100%;
                }

                /* Effets de paillettes */
                .sparkle-effect {
                    position: absolute;
                    top: -15px;
                    right: -15px;
                    width: 50px;
                    height: 50px;
                    pointer-events: none;
                }

                .sparkle {
                    position: absolute;
                    background: white;
                    border-radius: 50%;
                    opacity: 0;
                }

                .sparkle:nth-child(1) {
                    width: 5px;
                    height: 5px;
                    top: 10px;
                    right: 10px;
                    animation: sparkle 2s infinite;
                }

                .sparkle:nth-child(2) {
                    width: 3px;
                    height: 3px;
                    top: 5px;
                    right: 20px;
                    animation: sparkle 2.3s infinite 0.3s;
                }

                .sparkle:nth-child(3) {
                    width: 4px;
                    height: 4px;
                    top: 15px;
                    right: 5px;
                    animation: sparkle 1.7s infinite 0.7s;
                }

                @keyframes sparkle {
                    0% {
                        transform: scale(0);
                        opacity: 0;
                    }

                    50% {
                        opacity: 1;
                    }

                    100% {
                        transform: scale(1.5);
                        opacity: 0;
                    }
                }

                /* Badge Premium actif */
                .premium-active-badge {
                    position: relative;
                    display: inline-flex;
                    align-items: center;
                    gap: 10px;
                    padding: 14px 24px;
                    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
                    color: white;
                    font-weight: 500;
                    border-radius: 12px;
                    margin-top: 25px;
                    overflow: hidden;
                    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
                }

                .active-pulse {
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    background: radial-gradient(circle, rgba(255, 255, 255, 0.4) 0%, transparent 70%);
                    animation: pulse 3s infinite;
                    border-radius: 12px;
                    top: 0;
                    left: 0;
                    z-index: -1;
                }

                @keyframes pulse {
                    0% {
                        transform: scale(0.95);
                        opacity: 0.7;
                    }

                    50% {
                        transform: scale(1.05);
                        opacity: 0.3;
                    }

                    100% {
                        transform: scale(0.95);
                        opacity: 0.7;
                    }
                }

                /* Icônes SVG */
                .icon-crown,
                .badge-icon {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                /* Responsive */
                @media (max-width: 768px) {
                    .glowing-premium-btn {
                        padding: 14px 24px;
                        font-size: 0.9rem;
                    }

                    .premium-active-badge {
                        padding: 12px 20px;
                        font-size: 0.9rem;
                    }
                }
            </style>

            <!-- Propriétaire -->
            <div class="partner-card">
                <h4>👤 {{ $annonce->proprietaire->full_name ?? 'Propriétaire inconnu' }}</h4>
                <a href="/commentaires/{{ $annonce->proprietaire->id ?? 'Propriétaire inconnu' }}" style="color:#2980b9;">Voir commentaires sur le proprietaire</a>
            {{-- <p>Membre depuis {{ $annonce->proprietaire->created_at->diffForHumans() ?? 'date inconnue' }}</p> --}}
                @if ($annonce->proprietaire->moyenne_notes)
                    <p>⭐ Note moyenne : {{ number_format($annonce->proprietaire->moyenne_notes, 1) }}/5</p>
                @endif
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

        document.addEventListener('DOMContentLoaded', function() {
            const thumbnails = document.querySelectorAll('.thumbnail');
            const imageCount = {{ $annonce->objet->images->count() ?? 0 }};

            // Auto-slide seulement s'il y a plusieurs images
            if (imageCount > 1) {
                let index = 0;
                const interval = setInterval(() => {
                    index = (index + 1) % imageCount;
                    showImage(index);
                }, 3000);

                // Arrêter l'auto-slide quand on clique sur une miniature
                thumbnails.forEach(thumb => {
                    thumb.addEventListener('click', () => {
                        clearInterval(interval);
                    });
                });
            }
        });
    </script>

@endsection

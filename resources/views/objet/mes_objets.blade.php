@extends('layouts.app')

@section('content')
<style>
    .objets-container {
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

    .objets-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }

    .objet-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .objet-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .objet-images {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .objet-images img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .objet-card:hover .objet-images img {
        transform: scale(1.05);
    }

    .objet-details {
        padding: 20px;
    }

    .objet-title {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .objet-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }

    .objet-price {
        color: #27ae60;
        font-weight: bold;
    }

    .objet-location {
        color: #7f8c8d;
    }

    .objet-description {
        color: #7f8c8d;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .objet-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        color: #95a5a6;
        margin-bottom: 10px;
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #7f8c8d;
        font-size: 1.1rem;
        grid-column: 1 / -1;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .badge-category {
        background: #3498db;
        color: white;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 0.75rem;
    }
</style>

<div class="objets-container">
    <h2>Mes Objets</h2>
    
    @if($objets->isEmpty())
        <div class="empty-state">
            <p>Vous n'avez pas encore ajouté d'objets.</p>
            <a href="{{ route('objet.create') }}" class="btn btn-primary mt-3">Ajouter un objet</a>
        </div>
    @else
        <div class="objets-grid">
            @foreach($objets as $objet)
                <div class="objet-card">
                    <div class="objet-images">
                        @if($objet->images->isNotEmpty())
                            <img src="{{ asset($objet->images->first()->url) }}" alt="Image de {{ $objet->nom }}">
                        @else
                            <div style="background: #f5f5f5; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <span style="color: #999;">Aucune image</span>
                            </div>
                        @endif
                    </div>
                    <div class="objet-details">
                        <h3 class="objet-title">{{ $objet->nom }}</h3>
                        
                        <div class="objet-meta">
                            <span class="objet-price">{{ $objet->prix_journalier }} €/jour</span>
                            <span class="objet-location">{{ $objet->ville }}</span>
                        </div>
                        
                        <p class="objet-description">{{ Str::limit($objet->description, 100) }}</p>
                        
                        <div class="objet-footer">
                            <span class="badge-category">{{ $objet->categorie->nom ?? 'Non catégorisé' }}</span>
                            <span>Ajouté le {{ $objet->created_at->format('d/m/Y') }}</span>
                        </div>

                       <div class="action-buttons mt-2">
    <!-- Bouton Modifier -->
    <a href="{{ route('objet.edit', $objet->id) }}" 
       class="btn btn-sm btn-primary">
        <i class="fas fa-edit"></i> Modifier
    </a>
    
    <!-- Bouton Changer Statut -->
    <form action="{{ route('objet.toggleStatut', $objet->id) }}" method="POST" 
          onsubmit="return confirm('Voulez-vous changer le statut de cet objet ?')">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-sm {{ $objet->statut === 'active' ? 'btn-secondary' : 'btn-success' }}">
            <i class="fas {{ $objet->statut === 'active' ? 'fa-archive' : 'fa-check' }}"></i>
            {{ $objet->statut === 'active' ? 'Archiver' : 'Activer' }}
        </button>
    </form>
</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

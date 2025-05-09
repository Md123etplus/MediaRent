@extends('layouts.app')

@section('content')
<style>
    .archive-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 20px;
    }

    h2 {
        color: #2d3748;
        margin-bottom: 25px;
        font-size: 1.8rem;
        font-weight: 600;
        position: relative;
        padding-bottom: 10px;
    }

    h2::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 60px;
        height: 3px;
        background: #e53e3e;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 25px;
        border-left: 4px solid #34d399;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead th {
        background-color: #fff5f5;
        color: #e53e3e;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border-bottom: 2px solid #fed7d7;
    }

    .table tbody tr {
        transition: background-color 0.2s;
    }

    .table tbody tr:hover {
        background-color: #fff5f5;
    }

    .table tbody td {
        padding: 12px 15px;
        border-bottom: 1px solid #feebeb;
        color: #4a5568;
        vertical-align: middle;
    }

    .status-archived {
        background-color: #fff5f5;
        color: #e53e3e;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .btn-restore {
        background-color: #38a169;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        transition: all 0.2s;
        border: none;
    }

    .btn-restore:hover {
        background-color: #2f855a;
    }

    .empty-archive {
        text-align: center;
        padding: 40px;
        color: #718096;
    }

    .empty-archive i {
        font-size: 2rem;
        color: #e53e3e;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .archive-container {
            padding: 15px;
        }
        
        .table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<div class="archive-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-archive me-2"></i>Annonces Archivées
        </h2>
        <a href="{{ route('annonces.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Retour aux annonces actives
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($annonces->isEmpty())
        <div class="empty-archive">
            <i class="fas fa-box-open"></i>
            <p class="mt-3">Aucune annonce restaurer pour le moment</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Objet</th>
                        <th>Dates</th>
                        <th>Adresse</th>
                        <th>Date d'archivage</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($annonces as $annonce)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($annonce->objet->images->isNotEmpty())
                                        <img src="{{ asset('storage/'.$annonce->objet->images->first()->url) }}" 
                                             class="rounded me-3" 
                                             width="50" 
                                             height="50" 
                                             style="object-fit: cover">
                                    @endif
                                    <div>
                                        <strong>{{ $annonce->objet->nom }}</strong>
                                        <div class="text-muted small">{{ $annonce->objet->categorie->nom ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small>
                                    <div><strong>Début:</strong> {{ $annonce->date_debut->format('d/m/Y') }}</div>
                                    <div><strong>Fin:</strong> {{ $annonce->date_fin->format('d/m/Y') }}</div>
                                </small>
                            </td>
                            <td>{{ $annonce->adress }}</td>
                            <td>{{ $annonce->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <form action="{{ route('annonces.archive', $annonce->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-restore btn-sm" onclick="return confirm('archiver cette annonce ?')">
                                        <i class="fas fa-undo me-1"></i> archiver
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
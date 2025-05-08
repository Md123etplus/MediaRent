@extends('layouts.app')

@section('content')
<style>
    .container {
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
        background: #4299e1;
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

    .table-bordered {
        border: 1px solid #e2e8f0;
    }

    .table thead th {
        background-color: #f8fafc;
        color: #4a5568;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border-bottom: 2px solid #e2e8f0;
    }

    .table tbody tr {
        transition: background-color 0.2s;
    }

    .table tbody tr:hover {
        background-color: #f9fafb;
    }

    .table tbody td {
        padding: 12px 15px;
        border-bottom: 1px solid #edf2f7;
        color: #4a5568;
        vertical-align: middle;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .btn {
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-sm {
        padding: 6px 10px;
        font-size: 0.8125rem;
    }

    .btn-primary {
        background-color: #4299e1;
        color: white;
    }

    .btn-primary:hover {
        background-color: #3182ce;
    }

    .btn-warning {
        background-color: #ed8936;
        color: white;
    }

    .btn-warning:hover {
        background-color: #dd6b20;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    form {
        margin: 0;
    }

    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }
        
        .table {
            display: block;
            overflow-x: auto;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 6px;
        }
        
        .btn {
            width: 100%;
        }
    }

    /* Badges pour statut */
    .status-active {
        color: #38a169;
        background-color: #f0fff4;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }

    .status-archived {
        color: #e53e3e;
        background-color: #fff5f5;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }

    /* Style pour les valeurs booléennes */
    .premium-true {
        color: #9f7aea;
        font-weight: 500;
    }

    .premium-false {
        color: #a0aec0;
    }

    /* Style pour le bouton Restaurer */
.btn-success {
    background-color: #38a169;
    color: white;
}

.btn-success:hover {
    background-color: #2f855a;
}

/* Amélioration des boutons d'action */
.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* Responsive pour petits écrans */
@media (max-width: 576px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        width: 100%;
        justify-content: center;
    }
}
    
</style>
<div class="container">
    <h2>Mes Annonces</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date publication</th>
                <th>Statut</th>
                <th>Premium</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($annonces as $annonce)
            <tr>
                <td>{{ $annonce->id }}</td>
                <td>{{ $annonce->date_publication }}</td>
                <td>{{ $annonce->statut }}</td>
                <td>{{ $annonce->premium ? 'Oui' : 'Non' }}</td>
                <td>{{ $annonce->date_debut }}</td>
                <td>{{ $annonce->date_fin }}</td>
                <td>{{ $annonce->adress }}</td>
                <td>
    <div class="action-buttons">
        <!-- Bouton Modifier (toujours visible) -->
            <a href="{{ route('annonces.edit', $annonce->id) }}" 
            class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Modifier
            </a>
        
        @if($annonce->statut === 'active')
            <!-- Bouton Archiver (seulement si active) -->
            <form action="{{ route('annonces.archive', $annonce->id) }}" method="POST">
                @csrf
                <button type="submit" 
                        class="btn btn-sm btn-warning"
                        onclick="return confirm('Archiver cette annonce ?')">
                    <i class="fas fa-archive"></i> Archiver
                </button>
            </form>
        @else
            <!-- Bouton Restaurer (seulement si archivée) -->
            <form action="{{ route('annonces.restore', $annonce->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-success"
                 onclick="return confirm('Restaurer cette annonce ?')">
                <i class="fas fa-undo"></i> Restaurer
            </button>
            </form>
        @endif
        
    </div>
</td>
            </tr>
        @empty
            <tr><td colspan="8">Aucune annonce trouvée.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }
    /* Style spécifique au formulaire */
    h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 30px;
        font-size: 2rem;
        position: relative;
        padding-bottom: 10px;
    }

    h2::after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background: #3498db;
        margin: 10px auto 0;
    }

    .annonce-form {
        max-width: 600px;
        margin: 0 auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .annonce-form .form-group {
        margin-bottom: 1.5rem;
    }

    .annonce-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #2d3748;
        font-size: 0.95rem;
    }

    .annonce-form input,
    .annonce-form select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.2s ease;
        background-color: #f8fafc;
    }

    .annonce-form input:focus,
    .annonce-form select:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        background-color: #ffffff;
        outline: none;
    }

    .annonce-form .checkbox-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .annonce-form input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #4299e1;
    }

    .annonce-form .submit-btn {
        width: 100%;
        padding: 12px;
        background-color: #4299e1;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .annonce-form .submit-btn:hover {
        background-color: #3182ce;
    }

    /* Style pour les messages */
    .alert-message {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    /* Style responsive */
    @media (max-width: 640px) {
        .annonce-form {
            padding: 20px;
        }
    }

    .alert-danger {
    background-color: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fca5a5;
    }
</style>

<div class="form-container">
    <h2>Ajouter une annonce</h2>

    @if(session('success'))
        <div class="alert-message alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->has('limit'))
             <div class="alert-message alert-danger mb-4">
              {{ $errors->first('limit') }}
              <a href="{{ route('annonces.mes_annonces') }}" class="font-semibold underline">Voir mes annonces</a>
             </div>
    @endif
    <form class="annonce-form" action="{{ route('annonces.store') }}" method="POST">
        @csrf
        <input type="date" name="date_publication" value="{{ date('Y-m-d') }}" hidden>
        <input type="number" name="proprietaire_id" value="1" hidden>

        <div class="form-group">
            <label for="date_debut">Date début :</label>
            <input type="date" id="date_debut" name="date_debut" required>
        </div>

        <div class="form-group">
            <label for="date_fin">Date fin :</label>
            <input type="date" id="date_fin" name="date_fin" required>
        </div>


                    <div class="form-group">
                <label for="objet_id">Objet :</label>
                <select id="objet_id" name="objet_id" required>
                    @forelse($objets as $objet)
                        <option value="{{ $objet->id }}">
                            {{ $objet->nom }} 
                            @if($objet->categorie)
                                ({{ $objet->categorie->nom }})
                            @endif
                            - {{ $objet->prix_journalier }} DH/jour
                        </option>
                    @empty
                        <option value="" disabled>Vous n'avez aucun objet</option>
                    @endforelse
                </select>
                
                @if($objets->isEmpty())
                    <div class="mt-2 text-sm text-red-600">
                        Vous devez d'abord <a href="{{ route('objets.create') }}" class="text-blue-600 underline">créer un objet</a> avant de publier une annonce.
                    </div>
                @endif
            </div>
            
        <div class="form-group">
            <label for="statut">Statut :</label>
            <select id="statut" name="statut" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="form-group checkbox-container">
            <input type="checkbox" id="premium" name="premium" value="1">
            <label for="premium">Premium</label>
        </div>

        <button type="submit" class="submit-btn">Publier</button>
       
    </form>
</div>
@endsection
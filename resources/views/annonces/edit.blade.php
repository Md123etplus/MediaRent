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

    @media (max-width: 640px) {
        .annonce-form {
            padding: 20px;
        }
    }
</style>

<div class="form-container">
    <h2>Modifier l'annonce</h2>

    @if(session('success'))
        <div class="alert-message alert-success">{{ session('success') }}</div>
    @endif

    <form class="annonce-form" action="{{ route('annonces.update', $annonce->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="date_debut">Date début :</label>
            <input type="date" id="date_debut" name="date_debut" 
                   value="{{ old('date_debut', $annonce->date_debut) }}" required>
        </div>

        <div class="form-group">
            <label for="date_fin">Date fin :</label>
            <input type="date" id="date_fin" name="date_fin" 
                   value="{{ old('date_fin', $annonce->date_fin) }}" required>
        </div>

        <div class="form-group">
            <label for="adress">Adresse :</label>
            <input type="text" id="adress" name="adress" 
                   value="{{ old('adress', $annonce->adress) }}" required>
        </div>

        <div class="form-group">
            <label for="objet_id">Objet :</label>
            <select id="objet_id" name="objet_id" required>
                @foreach($objets as $objet)
                    <option value="{{ $objet->id }}" 
                        {{ $annonce->objet_id == $objet->id ? 'selected' : '' }}>
                        {{ $objet->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="statut">Statut :</label>
            <select id="statut" name="statut" required>
                <option value="active" {{ $annonce->statut == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $annonce->statut == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="form-group checkbox-container">
            <input type="checkbox" id="premium" name="premium" value="1" 
                {{ $annonce->premium ? 'checked' : '' }}>
            <label for="premium">Premium</label>
        </div>

        <button type="submit" class="submit-btn">Mettre à jour</button>
    </form>
</div>
@endsection
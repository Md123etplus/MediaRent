@extends('layouts.app')

@section('content')
<div class="premium-upgrade-flow">
    <!-- Étape 3 : Confirmation (visible directement après paiement) -->
    <div class="confirmation-container" id="confirmationStep">
        <div class="confirmation-content">
            <div class="checkmark">✓</div>
            <h2>Réservation confirmée !</h2>
            <p>Votre demande a été enregistrée avec succès</p>
            
            <div class="confirmation-details">
                <div class="detail-item">
                    <span>Référence :</span>
                    <span id="confirmation-reference">{{ $reference ?? 'MR-' . date('YmdHis') }}</span>
                </div>
                <div class="detail-item">
                    <span>Annonce :</span>
                    <span>{{ $annonce->titre }}</span>
                </div>
                <div class="detail-item">
                    <span>Dates :</span>
                    <span>
                       {{ isset($reservation['date_debut']) && $reservation['date_debut'] instanceof \Carbon\Carbon 
                            ? $reservation['date_debut']->format('d/m/Y') . ' - ' . $reservation['date_fin']->format('d/m/Y') 
                            : 'Dates non spécifiées' }}
                    </span>
                </div>
                @if(isset($reservation))
                <div class="detail-item">
                    <span>Montant :</span>
                    <span>{{ number_format($reservation['prix_total'], 2) }} Dhs</span>
                </div>
                @endif
            </div>

            <div class="confirmation-actions">
                <a href="{{ route('annonces.show', $annonce) }}" class="view-ad-btn">
                    <i class="fas fa-eye mr-2"></i>Voir mon annonce
                </a>
                <a href="{{ route('home') }}" class="back-to-search-btn">
                    <i class="fas fa-search mr-2"></i>Retour à la recherche
                </a>
            </div>

            <div class="confirmation-notice mt-6">
                <i class="fas fa-envelope text-blue-500 mr-2"></i>
                <span>Vous recevrez un email dès que le propriétaire aura confirmé votre réservation.</span>
            </div>
        </div>
    </div>
</div>

<style>
.confirmation-container {
    max-width: 600px;
    margin: 2rem auto;
    background: white;
    padding: 3rem;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    text-align: center;
}

.checkmark {
    font-size: 5rem;
    color: #00b894;
    margin-bottom: 1.5rem;
}

.confirmation-content h2 {
    font-size: 2rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

.confirmation-details {
    background: var(--light);
    padding: 1.5rem;
    border-radius: 8px;
    margin: 2rem 0;
    text-align: left;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
}

.detail-item span:first-child {
    font-weight: 500;
    color: var(--gray);
}

.detail-item span:last-child {
    font-weight: 600;
}

.confirmation-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
}

.view-ad-btn {
    display: inline-flex;
    align-items: center;
    background: var(--primary);
    color: white;
    padding: 0.8rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.view-ad-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.back-to-search-btn {
    display: inline-flex;
    align-items: center;
    background: var(--secondary);
    color: white;
    padding: 0.8rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-to-search-btn:hover {
    background: #00a8a3;
    transform: translateY(-2px);
}

.confirmation-notice {
    background: #f0f9ff;
    padding: 1rem;
    border-radius: 8px;
    color: var(--dark);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 2rem;
}
</style>
@endsection
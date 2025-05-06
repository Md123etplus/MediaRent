@extends('layouts.app')

@section('content')
<div class="premium-confirmation-container">
    <div class="premium-confirmation-card">
        <!-- Confetti animation -->
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
        
        <!-- Header avec badge -->
        <div class="premium-header">
            <div class="premium-badge">
                <i class="fas fa-crown"></i> PREMIUM
            </div>
            <h1>
                <i class="fas fa-check-circle"></i> Paiement confirmé
            </h1>
        </div>
        
        <!-- Message principal -->
        <div class="success-message">
            <div class="trophy-icon">
                <i class="fas fa-trophy"></i>
            </div>
            <h2>Félicitations !</h2>
            <p class="subtitle">Votre annonce est désormais en mode Premium</p>
        </div>
        
        <!-- Détails -->
        <div class="premium-details">
            <div class="detail-card">
                <i class="fas fa-receipt"></i>
                <div>
                    <span class="detail-label">Référence</span>
                    <span class="detail-value">{{ $reference }}</span>
                </div>
            </div>
            
            <div class="detail-card">
                <i class="fas fa-tag"></i>
                <div>
                    <span class="detail-label">Annonce</span>
                    <span class="detail-value">#{{ $annonce->id }} - {{ $annonce->objet->nom }}</span>
                </div>
            </div>
            
            <div class="detail-card">
                <i class="fas fa-calendar-alt"></i>
                <div>
                    <span class="detail-label">Validité</span>
                    <span class="detail-value">{{ $dateFin }} ({{ $joursRestants }} jours)</span>
                </div>
            </div>
        </div>
        
        <!-- Avantages -->
        <div class="premium-benefits">
            <h3><i class="fas fa-star"></i> Vos avantages</h3>
            <div class="benefits-grid">
                <div class="benefit-item">
                    <div class="benefit-icon" style="background-color: #4e73df;">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <span>Visibilité accrue</span>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon" style="background-color: #1cc88a;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span>Statistiques détaillées</span>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon" style="background-color: #f6c23e;">
                        <i class="fas fa-crown"></i>
                    </div>
                    <span>Badge exclusif</span>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon" style="background-color: #e74a3b;">
                        <i class="fas fa-headset"></i>
                    </div>
                    <span>Support prioritaire</span>
                </div>
            </div>
        </div>
        
        <!-- CTA -->
        <div class="action-buttons">
            <a href="{{ route('annonces.show', $annonce) }}" class="btn-primary">
                <i class="fas fa-eye"></i> Voir mon annonce
            </a>
            <a href="{{ route('partenaire.dashboard') }}" class="btn-secondary">
                <i class="fas fa-tachometer-alt"></i> Tableau de bord
            </a>
        </div>
    </div>
</div>

<style>
/* Variables */
:root {
    --primary: #4e73df;
    --secondary: #858796;
    --success: #1cc88a;
    --info: #36b9cc;
    --warning: #f6c23e;
    --danger: #e74a3b;
    --light: #f8f9fc;
    --dark: #5a5c69;
    --gold: #f6c23e;
}

/* Structure */
.premium-confirmation-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #f8f9fc 0%, #e2e8f0 100%);
    padding: 2rem;
}

.premium-confirmation-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 800px;
    padding: 3rem 2rem;
    position: relative;
    overflow: hidden;
    text-align: center;
}

/* Header */
.premium-header {
    margin-bottom: 2rem;
}

.premium-badge {
    background: linear-gradient(to right, #f6c23e, #daa520);
    color: white;
    display: inline-block;
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 15px rgba(246, 194, 62, 0.3);
}

.premium-header h1 {
    font-size: 2rem;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.premium-header h1 i {
    color: var(--success);
    margin-right: 0.5rem;
}

/* Message */
.success-message {
    margin-bottom: 2rem;
}

.trophy-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(to right, #f6c23e, #daa520);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 2rem;
    box-shadow: 0 4px 20px rgba(246, 194, 62, 0.4);
}

.success-message h2 {
    font-size: 1.8rem;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.subtitle {
    color: var(--secondary);
    font-size: 1.1rem;
}

/* Détails */
.premium-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 2rem 0;
}

.detail-card {
    background: var(--light);
    border-radius: 0.5rem;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    text-align: left;
    transition: transform 0.3s ease;
}

.detail-card:hover {
    transform: translateY(-5px);
}

.detail-card i {
    font-size: 1.5rem;
    color: var(--primary);
    margin-right: 1rem;
    width: 40px;
    height: 40px;
    background: rgba(78, 115, 223, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.detail-label {
    display: block;
    font-size: 0.8rem;
    color: var(--secondary);
    margin-bottom: 0.3rem;
}

.detail-value {
    font-weight: 600;
    color: var(--dark);
}

/* Avantages */
.premium-benefits {
    margin: 3rem 0;
}

.premium-benefits h3 {
    font-size: 1.3rem;
    color: var(--dark);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.premium-benefits h3 i {
    margin-right: 0.5rem;
    color: var(--gold);
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1.5rem;
}

.benefit-item {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.benefit-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-bottom: 0.8rem;
}

.benefit-item span {
    font-size: 0.9rem;
    color: var(--dark);
    text-align: center;
}

/* Boutons */
.action-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.btn-primary {
    background: linear-gradient(to right, var(--primary), #2e59d9);
    color: white;
    border: none;
    padding: 0.8rem 1.8rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4);
    color: white;
}

.btn-secondary {
    border: 2px solid var(--primary);
    color: var(--primary);
    background: transparent;
    padding: 0.8rem 1.8rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: var(--primary);
    color: white;
}

.btn-primary i, .btn-secondary i {
    margin-right: 0.5rem;
}

/* Confetti */
.confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    background: var(--gold);
    opacity: 0;
    animation: confetti 5s ease-in infinite;
}

.confetti:nth-child(1) {
    left: 10%;
    animation-delay: 0;
}
.confetti:nth-child(2) {
    left: 50%;
    animation-delay: 0.5s;
}
.confetti:nth-child(3) {
    left: 90%;
    animation-delay: 1.5s;
}

@keyframes confetti {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(500px) rotate(360deg);
        opacity: 0;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .premium-confirmation-card {
        padding: 2rem 1rem;
    }
    
    .premium-header h1 {
        font-size: 1.5rem;
    }
    
    .premium-details {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-primary, .btn-secondary {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ajout de confettis dynamiques
    function createConfetti() {
        const container = document.querySelector('.premium-confirmation-card');
        const colors = ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b', '#36b9cc'];
        
        for (let i = 0; i < 30; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.width = Math.random() * 8 + 5 + 'px';
            confetti.style.height = confetti.style.width;
            confetti.style.animationDuration = Math.random() * 3 + 2 + 's';
            confetti.style.animationDelay = Math.random() * 2 + 's';
            container.appendChild(confetti);
        }
    }
    
    createConfetti();
});
</script>
@endsection
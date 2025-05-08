@extends('layouts.app')

@section('content')
<div class="premium-upgrade-flow">
    <!-- Étape 1 : Sélection de la formule -->
    <div class="formula-selection" id="formulaStep">
        <div class="header">
            <h1>Boostez votre annonce avec Premium</h1>
            <p>Sélectionnez la formule qui maximise votre visibilité</p>
        </div>

        <div class="formula-cards">
            @foreach($plans as $plan)
            <div class="formula-card" data-plan-id="{{ $plan['id'] }}">
                <div class="popular-badge" style="display: {{ $plan['id'] == 2 ? 'block' : 'none' }}">
                    <i class="fas fa-star"></i> Populaire
                </div>
                <div class="card-header">
                    <h3>{{ $plan['name'] }}</h3>
                    <div class="price">{{ $plan['price'] }} €</div>
                </div>
                <ul class="features">
                    <li><i class="fas fa-check-circle"></i> Mise en avant pendant {{ $plan['duration_days'] }} jours</li>
                    <li><i class="fas fa-check-circle"></i> Badge Premium visible</li>
                    <li><i class="fas fa-check-circle"></i> Position prioritaire dans les résultats</li>
                    <li><i class="fas fa-check-circle"></i> +300% de visibilité</li>
                </ul>
                <button class="select-btn" data-plan-id="{{ $plan['id'] }}">
                    <span>Sélectionner</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Étape 2 : Paiement (caché initialement) -->
    <div class="payment-container" id="paymentStep" style="display: none;">
        <div class="back-btn" id="backToFormulas">
            <i class="fas fa-arrow-left"></i> Changer de formule
        </div>

        <div class="payment-header">
        <div class="payment-progress">
            <div class="step active">1. Choix</div>
            <div class="step active">2. Paiement</div>
            <div class="step">3. Confirmation</div> 
        </div>
            <h2>Finalisez votre abonnement Premium</h2>
            <div class="selected-plan" id="selectedPlanDisplay">
                <!-- Rempli dynamiquement -->
            </div>
        </div>

        <form method="POST" action="{{ route('annonces.process-payment', $annonce) }}" id="paymentForm">
            @csrf
            <input type="hidden" name="plan_id" id="selectedPlanId">

            <div class="payment-content">
                <!-- Section Carte Bancaire -->
                <div class="payment-section">
                    <h3><i class="fas fa-credit-card"></i> Informations de paiement</h3>
                    
                    <div class="card-visual">
                        <div class="card-front">
                            <div class="card-logo">
                                <div class="chip"></div>
                                <span>MediaRent</span>
                            </div>
                            <div class="card-number">
                                <input type="text" name="card_number" placeholder="4242 4242 4242 4242" 
                                    required pattern="[\d ]{19}" id="cardNumber">
                            </div>
                            <div class="card-details">
                                <!-- Remplacer le champ existant par : -->
                                <div class="card-holder">
                                    <input type="text" name="card_holder" placeholder="NOM TITULAIRE" 
                                        value="{{ auth()->user()->nom }} {{ auth()->user()->prenom }}" required>
                                </div>
                                <div class="card-expiry">
                                    <input type="text" name="expiry_date" placeholder="MM/AA" required
                                           pattern="\d{2}/\d{2}" maxlength="5" id="expiryDate">
                                </div>
                            </div>
                        </div>
                        <div class="card-back">
                            <div class="card-cvv">
                                <input type="text" name="cvv" placeholder="CVV" required
                                       pattern="\d{3}" maxlength="3" id="cvv">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Résumé -->
                <div class="order-summary">
                    <h3><i class="fas fa-receipt"></i> Récapitulatif</h3>
                    <div class="summary-details">
                        <div class="summary-item">
                            <span>Formule :</span>
                            <span id="summary-plan-name"></span>
                        </div>
                        <div class="summary-item">
                            <span>Durée :</span>
                            <span id="summary-plan-duration"></span>
                        </div>
                        <div class="summary-item total">
                            <span>Total :</span>
                            <span id="summary-plan-price"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment-actions">
                <button type="submit" class="pay-now-btn" id="submitBtn">
                    <span class="btn-content">
                        <i class="fas fa-lock"></i>
                        <span>Payer maintenant</span>
                    </span>
                    <span class="btn-loading">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </button>
                <div class="payment-security">
                    <i class="fas fa-shield-alt"></i>
                    <span>Paiement 100% sécurisé</span>
                </div>
            </div>
        </form>
    </div>


    <!-- Étape 3 : Confirmation (à ajouter ici) -->
<div class="confirmation-container" id="confirmationStep" style="display: none;">
    <div class="confirmation-content">
        <div class="checkmark">✓</div>
        <h2>Paiement confirmé !</h2>
        <p>Votre annonce est maintenant en mode Premium</p>
        
        <div class="confirmation-details">
            <div class="detail-item">
                <span>Référence :</span>
                <span id="confirmation-reference">MR-{{ date('YmdHis') }}</span>
            </div>
            <div class="detail-item">
                <span>Montant :</span>
                <span id="confirmation-amount"></span>
            </div>
        </div>
        
        <a href="{{ route('annonces.show', $annonce) }}" class="view-ad-btn">
            Voir mon annonce
        </a>
    </div>
</div>

</div>

<style>
:root {
    --primary: #6c5ce7;
    --primary-light: #a29bfe;
    --primary-dark: #5649c0;
    --secondary: #00cec9;
    --success: #00b894;
    --warning: #fdcb6e;
    --danger: #d63031;
    --dark: #2d3436;
    --light: #f5f6fa;
    --gray: #636e72;
    --light-gray: #dfe6e9;
}
.card-number input,
.card-holder input,
.card-expiry input {
    /* ... autres styles ... */
    letter-spacing: normal; /* Enlève l'espacement des lettres qui pouvait causer des problèmes */
}

.card-holder input {
    text-transform: uppercase; /* Pour uniformiser la saisie du nom */
}

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

.detail-item span:last-child {
    font-weight: 600;
}

.view-ad-btn {
    display: inline-block;
    background: var(--primary);
    color: white;
    padding: 1rem 2rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.view-ad-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}
/* Structure principale */
.premium-upgrade-flow {
    max-width: 1200px;
    margin: 2rem auto;
    font-family: 'Segoe UI', system-ui, sans-serif;
    color: var(--dark);
}

/* Étape 1 : Sélection de formule */
.formula-selection .header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 0 1rem;
}

.formula-selection .header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.formula-selection .header p {
    font-size: 1.2rem;
    color: var(--gray);
    max-width: 600px;
    margin: 0 auto;
}

.formula-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin: 0 auto;
    padding: 0 1rem;
}

.formula-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    border: 2px solid var(--light-gray);
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

.popular-badge {
    position: absolute;
    top: 15px;
    right: -30px;
    background: var(--warning);
    color: var(--dark);
    padding: 0.3rem 2rem;
    font-size: 0.9rem;
    font-weight: 600;
    transform: rotate(45deg);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.popular-badge i {
    margin-right: 0.3rem;
}

.formula-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    border-color: var(--primary-light);
}

.card-header {
    text-align: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--light-gray);
    position: relative;
}

.card-header h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.price {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--dark);
    position: relative;
    display: inline-block;
}

.price::after {
    content: 'TTC';
    font-size: 1rem;
    font-weight: 400;
    color: var(--gray);
    position: absolute;
    bottom: -5px;
    right: -30px;
}

.features {
    flex: 1;
    margin: 1.5rem 0;
    padding: 0;
    list-style: none;
}

.features li {
    margin-bottom: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 0.8rem;
    line-height: 1.4;
}

.features i {
    color: var(--success);
    font-size: 1.1rem;
    margin-top: 0.2rem;
}

.select-btn {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: auto;
    width: 100%;
    box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.select-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(108, 92, 231, 0.4);
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
}

/* Étape 2 : Paiement */
.payment-container {
    background: white;
    border-radius: 16px;
    padding: 3rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    display: none;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary);
    font-weight: 500;
    margin-bottom: 1.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    background: none;
    border: none;
    padding: 0;
}

.back-btn:hover {
    color: var(--primary-dark);
}

.payment-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.payment-progress {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.step {
    position: relative;
    color: var(--gray);
    font-weight: 500;
}

.step.active {
    color: var(--primary);
    font-weight: 600;
}

.step.active::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 100%;
    height: 3px;
    background: var(--primary);
    border-radius: 3px;
}

.payment-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 1rem;
}

.selected-plan {
    background: var(--light);
    padding: 1rem 1.5rem;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 1.5rem;
    font-weight: 600;
    margin-top: 1rem;
}

.plan-price {
    color: var(--primary);
    font-weight: 700;
}

.payment-content {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

@media (min-width: 992px) {
    .payment-content {
        grid-template-columns: 2fr 1fr;
    }
}

.payment-section {
    margin-bottom: 2rem;
}

.payment-section h3 {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.card-visual {
    perspective: 1000px;
    margin-bottom: 2rem;
}

.card-front, .card-back {
    background: linear-gradient(135deg, #434343 0%, #2d3436 100%);
    border-radius: 12px;
    padding: 1.5rem;
    color: white;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.card-front {
    position: relative;
    z-index: 2;
    margin-bottom: -60px;
    transform: translateY(60px);
    transition: transform 0.6s ease;
}

.card-back {
    height: 180px;
    position: relative;
    z-index: 1;
    padding-top: 2.5rem;
}

.card-visual:hover .card-front {
    transform: translateY(20px);
}

.card-logo {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.chip {
    width: 40px;
    height: 30px;
    background: linear-gradient(135deg, #fdcb6e 0%, #e17055 100%);
    border-radius: 5px;
}

.card-number {
    margin-bottom: 1.5rem;
}

.card-number input {
    width: 100%;
    background: transparent;
    border: none;
    border-bottom: 1px solid rgba(255,255,255,0.3);
    color: white;
    font-size: 1.1rem;
    padding: 0.3rem 0;
    letter-spacing: 0.1rem;
}

.card-number input::placeholder {
    color: rgba(255,255,255,0.5);
}

.card-details {
    display: flex;
    gap: 1.5rem;
}

.card-holder {
    flex: 2;
}

.card-expiry {
    flex: 1;
}

.card-holder input,
.card-expiry input {
    width: 100%;
    background: transparent;
    border: none;
    border-bottom: 1px solid rgba(255,255,255,0.3);
    color: white;
    font-size: 1rem;
    padding: 0.3rem 0;
}

.card-back {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.card-cvv {
    position: relative;
}

.card-cvv::before {
    content: 'CVV';
    position: absolute;
    top: -25px;
    left: 0;
    color: white;
    font-size: 0.8rem;
}

.card-cvv input {
    width: 60px;
    text-align: center;
    background: white;
    color: var(--dark);
    border-radius: 4px;
    padding: 0.5rem;
    font-weight: 600;
}

.order-summary {
    background: var(--light);
    padding: 1.5rem;
    border-radius: 12px;
    align-self: start;
    position: sticky;
    top: 20px;
}

.order-summary h3 {
    margin-bottom: 1.5rem;
}

.summary-details {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid var(--light-gray);
}

.summary-item.total {
    font-weight: 700;
    font-size: 1.1rem;
    border-bottom: none;
    padding-top: 0.8rem;
    margin-top: 0.5rem;
}

.payment-actions {
    grid-column: 1 / -1;
    text-align: center;
    margin-top: 1rem;
}

.pay-now-btn {
    position: relative;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.8rem;
    width: 100%;
    max-width: 400px;
}

.pay-now-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(108, 92, 231, 0.6);
}

.btn-content, .btn-loading {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.btn-loading {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    opacity: 0;
    justify-content: center;
}

.payment-security {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: var(--gray);
    font-size: 0.9rem;
    margin-top: 1rem;
}

.payment-security i {
    color: var(--success);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

/* Responsive */
@media (max-width: 768px) {
    .formula-cards {
        grid-template-columns: 1fr;
    }
    
    .payment-container {
        padding: 2rem 1.5rem;
    }
    
    .card-details {
        flex-direction: column;
        gap: 1rem;
    }
    
    .payment-content {
        grid-template-columns: 1fr;
    }
    
    .order-summary {
        position: static;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formulaStep = document.getElementById('formulaStep');
    const paymentStep = document.getElementById('paymentStep');
    const backToFormulas = document.getElementById('backToFormulas');
    const selectedPlanDisplay = document.getElementById('selectedPlanDisplay');
    const selectedPlanId = document.getElementById('selectedPlanId');
    const paymentForm = document.getElementById('paymentForm');
    
    // Éléments du récapitulatif
    const summaryPlanName = document.getElementById('summary-plan-name');
    const summaryPlanDuration = document.getElementById('summary-plan-duration');
    const summaryPlanPrice = document.getElementById('summary-plan-price');
    
    // Sélection d'une formule
    document.querySelectorAll('.select-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const planId = this.getAttribute('data-plan-id');
            const planCard = this.closest('.formula-card');
            const planName = planCard.querySelector('h3').textContent;
            const planPrice = planCard.querySelector('.price').textContent;
            const planDuration = planCard.querySelectorAll('li')[0].textContent.match(/\d+/)[0] + ' jours';
            
            // Mettre à jour l'affichage
            selectedPlanDisplay.innerHTML = `
                <span>${planName}</span>
                <span class="plan-price">${planPrice}</span>
            `;
            selectedPlanId.value = planId;
            
            // Mettre à jour le récapitulatif
            summaryPlanName.textContent = planName;
            summaryPlanDuration.textContent = planDuration;
            summaryPlanPrice.textContent = planPrice;
            
            // Basculer vers l'étape de paiement
            formulaStep.style.display = 'none';
            paymentStep.style.display = 'block';
            paymentStep.classList.add('fade-in');
            
            // Scroll vers le haut
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
    
    // Retour à la sélection de formule
    backToFormulas.addEventListener('click', function() {
        paymentStep.style.display = 'none';
        formulaStep.style.display = 'block';
        formulaStep.classList.add('fade-in');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    // Formatage des inputs
    const expiryInput = document.getElementById('expiryDate');
    if (expiryInput) {
        expiryInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            this.value = value;
        });
    }
    
    // Formatage du numéro de carte
    const cardNumberInput = document.getElementById('cardNumber');
        if (cardNumberInput) {
            cardNumberInput.addEventListener('input', function(e) {
                // Garder position du curseur
                const cursorPosition = this.selectionStart;
                const originalLength = this.value.length;
                
                // Nettoyer et formater
                let value = this.value.replace(/\D/g, '');
                if (value.length > 16) value = value.substr(0, 16);
                
                let formatted = '';
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) formatted += ' ';
                    formatted += value[i];
                }
                
                this.value = formatted;
                
                // Restaurer position du curseur
                if (originalLength < this.value.length) {
                    this.setSelectionRange(cursorPosition + 1, cursorPosition + 1);
                } else {
                    this.setSelectionRange(cursorPosition, cursorPosition);
                }
            });
        }
    // Formatage du CVV
    const cvvInput = document.getElementById('cvv');
    if (cvvInput) {
        cvvInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').substring(0, 3);
        });
    }
    
    // Soumission du formulaire
    // Soumission réelle du formulaire (supprimez la simulation)
    paymentForm.addEventListener('submit', function(e) {
        // Afficher le loader
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.querySelector('.btn-content').style.opacity = '0';
        submitBtn.querySelector('.btn-loading').style.opacity = '1';
        
        // Le formulaire se soumettra normalement
    });
});
</script>
@endsection
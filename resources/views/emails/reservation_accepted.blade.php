
<!DOCTYPE html>
<html>
<head>
    <title>Réservation Acceptée</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #48bb78; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; background-color: #f7fafc; border-radius: 0 0 8px 8px; }
        .button { 
            display: inline-block; 
            padding: 10px 20px; 
            margin: 5px;
            background-color: #4299e1; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
        }
        .button-partenaire {
            background-color: #9f7aea;
        }
        .button-paiement {
            background-color: #38a169;
        }
        .button-container {
            margin: 20px 0;
            text-align: center;
        }
        ul { margin: 10px 0; padding-left: 20px; }
        li { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Réservation Confirmée!</h1>
        </div>
        <div class="content">
            <p>Bonjour {{ $client->prenom ?? 'Client' }},</p>
            <p>Votre réservation pour <strong>{{ $annonce->objet->nom ?? 'Annonce' }}</strong> a été acceptée par le propriétaire.</p>
            
            <h3>Détails de la réservation :</h3>
            <ul>
                <li>Du: {{ $reservation->date_debut->format('d/m/Y') }}</li>
                <li>Au: {{ $reservation->date_fin->format('d/m/Y') }}</li>
                <li>Prix total: {{ $reservation->date_debut->diffInDays($reservation->date_fin) * $annonce->objet->prix_journalier }} €</li>
                <li>Propriétaire: {{ $annonce->proprietaire->name }}</li>
            </ul>
            
            <div class="button-container">
                <a href="{{ route('partenaire.show', ['user' => $annonce->proprietaire->id]) }}" class="button button-partenaire">
                    Voir fiche partenaire
                </a>
                <a href="{{ route('reservations.payment', ['annonce' => $annonce->id]) }}" class="button button-paiement">
                    Procéder au paiement
                </a>
            </div>
            
            <p style="margin-top: 30px;">Vous pouvez contacter le propriétaire directement à cette adresse : <a href="mailto:{{ $annonce->proprietaire->email }}">{{ $annonce->proprietaire->email }}</a></p>
        </div>
    </div>
</body>
</html>

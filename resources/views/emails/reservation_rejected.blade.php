<!DOCTYPE html>
<html>
<head>
    <title>Réservation Refusée</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #e53e3e; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; background-color: #f7fafc; border-radius: 0 0 8px 8px; }
        .button { display: inline-block; padding: 10px 20px; background-color: #4299e1; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Réservation Non Acceptée</h1>
        </div>
        <div class="content">
            <p>Bonjour {{ $client->prenom ?? 'Client' }},</p>
            <p>Nous regrettons de vous informer que votre réservation pour <strong>{{ $annonce->objet->nom ?? 'Annonce' }}</strong> n'a pas pu être acceptée.</p>
            
            <h3>Détails de la réservation :</h3>
            <ul>
                <li>Du: {{ $reservation->date_debut->format('d/m/Y') }}</li>
                <li>Au: {{ $reservation->date_fin->format('d/m/Y') }}</li>
            </ul>
            
            <p>Nous vous invitons à découvrir d'autres annonces disponibles :</p>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('annonces.index') }}" class="button">Voir les annonces</a>
            </div>
            
            <p style="margin-top: 20px; font-style: italic;">L'équipe MediaRent</p>
        </div>
    </div>
</body>
</html>
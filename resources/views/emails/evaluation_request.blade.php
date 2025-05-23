<!DOCTYPE html>
<html>
<head>
    <title>Evaluation de votre location</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #4a5568; }
        .card { 
            border: 1px solid #e2e8f0; 
            border-radius: 8px; 
            padding: 20px; 
            margin-bottom: 20px;
            background-color: #f8fafc;
        }
        h1 { color: #2b6cb0; margin-bottom: 10px; }
        h2 { color: #4a5568; margin-top: 20px; }
        .button-container { margin-top: 30px; text-align: center; }
        .button { 
            display: inline-block; 
            padding: 12px 24px; 
            background-color: #4299e1; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .button:hover { background-color: #3182ce; }
        .details { margin-bottom: 15px; }
        .detail-label { font-weight: bold; color: #2d3748; }
        .expiry-notice { 
            margin-top: 30px; 
            font-size: 0.9em; 
            color: #718096;
            text-align: center;
        }
        .evaluation-points { margin-left: 20px; }
        .evaluation-points li { margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Evaluation de votre location #{{ $reservation->id }}</h1>
        
        <p>Bonjour {{ $isClient ? $reservation->client->prenom : $reservation->annonce->proprietaire->prenom }},</p>
        
        <p>Merci d'avoir utilisé notre plateforme. Nous aimerions recueillir votre avis sur votre expérience.</p>
        
        <h2>Veuillez évaluer :</h2>
        
        @if($isClient)
        <ul class="evaluation-points">
            <li>L'état du matériel reçu</li>
            <li>La sympathie et professionnalisme du partenaire</li>
        </ul>
        @else
        <ul class="evaluation-points">
            <li>La sympathie et ponctualité du client</li>
            <li>Le respect du matériel</li>
        </ul>
        @endif
        
        <div class="details">
            <p><span class="detail-label">Location :</span> {{ $reservation->annonce->objet->nom }}</p>
            <p><span class="detail-label">Période :</span> 
                du {{ Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }} 
                au {{ Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
            </p>
        </div>
        
        <div class="button-container">
            <a href="{{ route('evaluations.create', [
                'reservation' => $reservation->id,
                'type' => $evaluationType,
            ]) }}" class="button">
                Donner votre avis
            </a>
        </div>
        
        <p class="expiry-notice">
            Ce lien expirera dans {{ 7 - $reservation->date_fin->diffInDays(now()) }} jours.
            <br><br>
            Merci pour votre contribution,<br>
            L'équipe {{ config('app.name') }}
        </p>
    </div>
</body>
</html>
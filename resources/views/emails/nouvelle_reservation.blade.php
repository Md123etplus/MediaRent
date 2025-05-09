<!DOCTYPE html>
<html>
<head>
    <title>Nouvelle Réservation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .card { border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        h2 { color: #2b6cb0; }
        h3 { color: #4a5568; }
        .button-container { margin-top: 30px; text-align: center; }
        .button { display: inline-block; padding: 10px 20px; margin: 0 10px; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .accept { background-color: #48bb78; }
        .reject { background-color: #e53e3e; }
        .image-container { display: flex; gap: 20px; margin-top: 15px; }
        .cin-image { max-width: 300px; border: 1px solid #ddd; border-radius: 4px; }
        .image-placeholder { 
            width: 300px; 
            height: 200px; 
            background-color: #f3f4f6; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            border: 1px dashed #d1d5db;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <h2>Nouvelle Réservation Reçue</h2>
    
    @if($annonce && $annonce->objet)
        <div class="card">
            <h3>Détails de l'annonce</h3>
            <p><strong>Objet :</strong> {{ $annonce->objet->nom ?? 'Non spécifié' }}</p>
            <p><strong>Prix journalier :</strong> {{ $annonce->objet->prix_journalier ?? '0' }} €</p>
        </div>
    @endif
    
    @if($reservation)
        <div class="card">
            <h3>Période de réservation</h3>
            <p><strong>Du :</strong> {{ $reservation->date_debut->format('d/m/Y') }}</p>
            <p><strong>Au :</strong> {{ $reservation->date_fin->format('d/m/Y') }}</p>
            <p><strong>Durée :</strong> {{ $reservation->date_debut->diffInDays($reservation->date_fin) }} jours</p>
            <p><strong>Prix total :</strong> {{ $reservation->date_debut->diffInDays($reservation->date_fin) * $annonce->objet->prix_journalier }} €</p>
        </div>
    @endif
    
    @if($client)
        <div class="card">
            <h3>Informations Client</h3>
            <p><strong>Nom complet :</strong> {{ $client->prenom }} {{ $client->nom }}</p>
            <p><strong>Email :</strong> {{ $client->email }}</p>
            <p><strong>CIN :</strong> {{ $client->CIN }}</p>
            
            <h4 style="margin-top: 15px;">Pièces d'identité :</h4>
            <div class="image-container">
                <div>
                    <p>Recto CIN</p>
                    @php
                        $frontFilename = basename($client->img_cin_front);
                        $frontPath = 'cin_front/' . $frontFilename;
                        $fullFrontPath = storage_path('app/public/' . $frontPath);
                    @endphp
                    @if(file_exists($fullFrontPath))
                        <img src="{{ $message->embed($fullFrontPath) }}" class="cin-image" alt="Recto CIN">
                    @else
                        <div class="image-placeholder">
                            <div>
                                <p>Image recto introuvable</p>
                                <p style="font-size: 0.8em;">Fichier: {{ $frontFilename }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div>
                    <p>Verso CIN</p>
                    @php
                        $backFilename = basename($client->img_cin_back);
                        $backPath = 'cin_back/' . $backFilename;
                        $fullBackPath = storage_path('app/public/' . $backPath);
                    @endphp
                    @if(file_exists($fullBackPath))
                        <img src="{{ $message->embed($fullBackPath) }}" class="cin-image" alt="Verso CIN">
                    @else
                        <div class="image-placeholder">
                            <div>
                                <p>Image verso introuvable</p>
                                <p style="font-size: 0.8em;">Fichier: {{ $backFilename }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="button-container">
        <a href="{{ route('client.reservations.response', ['id' => $reservation->id, 'response' => 'accept']) }}" class="button accept">Accepter la réservation</a>
        <a href="{{ route('client.reservations.response', ['id' => $reservation->id, 'response' => 'reject']) }}" class="button reject">Refuser la réservation</a>
    </div>

    <p style="margin-top: 30px; font-size: 0.9em; color: #718096;">
        Vous avez 48 heures pour répondre à cette demande de réservation.
    </p>
</body>
</html>
@component('mail::message')
# Évaluation de votre location #{{ $reservation->id }}

Bonjour {{ $isClient ? $reservation->client->prenom : $reservation->annonce->proprietaire->prenom }},

Merci d'avoir utilisé notre plateforme. Nous aimerions recueillir votre avis sur votre expérience.

@if($isClient)
**Veuillez évaluer :**
- L'état du matériel reçu
- La sympathie et professionnalisme du partenaire
@else
**Veuillez évaluer :**
- La sympathie et ponctualité du client
@endif

@component('mail::button', ['url' => $url])
Donner votre avis
@endcomponent

Ce lien expirera dans 7 jours.

Merci pour votre contribution,<br>
L'équipe {{ config('app.name') }}
@endcomponent

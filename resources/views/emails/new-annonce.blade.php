@component('mail::message')
# Nouvelle Annonce Disponible

Une nouvelle annonce vient d’être publiée :

- **Date** : {{ $annonce->date_publication }}
- **Adresse** : {{ $annonce->adress }}
- **Statut** : {{ $annonce->statut }}

@component('mail::button', ['url' => route('annonces.show', $annonce->id)])
Voir l'annonce
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent

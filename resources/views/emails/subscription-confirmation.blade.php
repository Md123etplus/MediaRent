@component('mail::message')
# Merci pour votre abonnement !

Vous avez récemment souscrit à notre newsletter. Cliquez le bouton ci-dessous pour confirmer votre abonnement.

@component('mail::button', ['url' => route('newsletter.confirm', ['token' => $subscriber->confirmation_token])])
Confirmer mon abonnement
@endcomponent

Si vous n'avez pas demandé cet abonnement, vous pouvez ignorer cet email.

Merci,<br>
{{ config('app.name') }}
@endcomponent
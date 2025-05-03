@component('mail::message')
# Nouveau message de contact

**Nom :** {{ $data['name'] }}

**Email :** {{ $data['email'] }}

**Sujet :** {{ $data['subject'] }}

**Message :**  
{{ $data['message'] }}

@endcomponent

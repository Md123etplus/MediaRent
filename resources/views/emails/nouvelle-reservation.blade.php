<!-- resources/views/emails/nouvelle_reservation.blade.php -->

<h2>Nouvelle réservation reçue</h2>

<p><strong>Objet :</strong> {{ $annonce->objet->nom }}</p>
<p><strong>Client :</strong> {{ $utilisateur->nom }} {{ $utilisateur->prenom }}</p>
<p><strong>Email :</strong> {{ $utilisateur->email }}</p>
<p><strong>CIN :</strong> {{ $utilisateur->CIN }}</p>
<p><strong>Date d'inscription :</strong> {{ $utilisateur->created_at->format('d/m/Y') }}</p>
<!--
<p><strong>Image de profil :</strong></p>
<img src="{{ asset('storage/'.$utilisateur->img_profil) }}" alt="Profil" width="100">

<p><strong>Carte d'identité - Recto :</strong></p>
<img src="{{ asset('storage/'.$utilisateur->img_cin_front) }}" alt="CIN Recto" width="200">

<p><strong>Carte d'identité - Verso :</strong></p>
<img src="{{ asset('storage/'.$utilisateur->img_cin_back) }}" alt="CIN Verso" width="200">
-->


<p><strong>Période de réservation :</strong> {{ $reservation->date_debut }} → {{ $reservation->date_fin }}</p>
<hr>
<p>Pour confirmer ou refuser, cliquez :</p>
<ul>
  <li>
    <a href="{{ route('reservations.reponse', ['id'=>$reservation->id,'decision'=>'accepter']) }}">
      ✅ Accepter
    </a>
  </li>
  <li>
    <a href="{{ route('reservations.reponse', ['id'=>$reservation->id,'decision'=>'refuser']) }}">
      ❌ Refuser
    </a>
  </li>
</ul>

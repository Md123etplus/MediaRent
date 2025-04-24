<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NouvelleReservation extends Mailable
{
    public $reservation;
    public $utilisateur;
    public $annonce;

    public function __construct($reservation, $utilisateur, $annonce)
    {
        $this->reservation = $reservation;
        $this->utilisateur = $utilisateur;
        $this->annonce = $annonce;
    }

    public function build()
    {
        return $this->from($this->utilisateur->email, $this->utilisateur->nom) // ✅ Utilisateur connecté
                    ->subject('Nouvelle demande de réservation')
                    ->view('emails.nouvelle-reservation')
                    ->with([
                        'reservation' => $this->reservation,
                        'utilisateur' => $this->utilisateur,
                        'annonce' => $this->annonce
                    ]);
    }
}

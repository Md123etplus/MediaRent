<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouvelleReservation extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $annonce;
    public $client;

    public function __construct($reservation, $annonce, $client)
    {
        $this->reservation = $reservation;
        $this->annonce = $annonce;
        $this->client = $client;
    }

public function build()
{
    $annonceName = $this->annonce->objet->nom ?? 'Annonce sans nom';
    return $this->subject("Nouvelle Réservation: $annonceName")
               ->view('emails.nouvelle_reservation');
}
}
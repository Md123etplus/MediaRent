<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationRejected extends Mailable
{
    protected $reservation;
    protected $annonce;

    public function __construct($reservation, $annonce)
    {
        $this->reservation = $reservation;
        $this->annonce = $annonce;
    }

    public function build()
    {
        return $this->subject('Statut de votre réservation')
                   ->view('emails.reservation_rejected')
                   ->with([
                       'reservation' => $this->reservation,
                       'annonce' => $this->annonce,
                       'client' => $this->reservation->client
                   ]);
    }

}
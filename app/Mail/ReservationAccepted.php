<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationAccepted extends Mailable
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
        return $this->subject('Votre réservation a été acceptée !')
                   ->view('emails.reservation_accepted')
                   ->with([
                       'reservation' => $this->reservation,
                       'annonce' => $this->annonce,
                       'client' => $this->reservation->client
                   ]);
    }

}
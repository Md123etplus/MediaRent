<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class EvaluationRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $evaluationType;

    public function __construct(Reservation $reservation, string $evaluationType)
    {
        $this->reservation = $reservation;
        $this->evaluationType = $evaluationType;
    }

    public function build()
    {
        $url = URL::signedRoute('evaluations.create', [
            'reservation' => $this->reservation->id,
            'type' => $this->evaluationType,
        ]);

        return $this->markdown('emails.evaluation_request')
            ->subject('Évaluation de votre location')
            ->with([
                'url' => $url,
                'isClient' => $this->evaluationType === 'client',
                'reservation' => $this->reservation,
            ]);
    }
}

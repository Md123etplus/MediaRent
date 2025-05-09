<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Annonce;

class NewAnnonceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $annonce;

    public function __construct(Annonce $annonce)
    {
        $this->annonce = $annonce;
    }

    public function build()
    {
        return $this->subject('Nouvelle annonce disponible')
                    ->markdown('emails.new-annonce');
    }
}

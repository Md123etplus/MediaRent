<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class NewBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Envoi par email + stockage en BDD
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle réservation pour votre annonce')
            ->line('Une nouvelle réservation a été effectuée pour votre annonce : ' . $this->booking->ad->title)
            ->action('Voir la réservation', url('/bookings/' . $this->booking->id))
            ->line('Merci d\'utiliser notre plateforme !');
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'ad_title' => $this->booking->ad->title,
            'client_name' => $this->booking->client->name,
            'message' => 'Une nouvelle réservation a été effectuée.',
        ];
    }
}
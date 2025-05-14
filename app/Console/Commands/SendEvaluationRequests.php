<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Mail\EvaluationRequestMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendEvaluationRequests extends Command
{
    protected $signature = 'evaluations:send-requests';
    protected $description = 'Send evaluation requests after rental ends';

    public function handle()
    {
        $reservations = Reservation::where('statut', 'terminée')
            ->where('date_fin', Carbon::yesterday())
            ->whereDoesntHave('evaluations')
            ->with(['client', 'annonce.proprietaire'])
            ->get();

        foreach ($reservations as $reservation) {
            // Envoi au client
            Mail::to($reservation->client->email)->send(
                new EvaluationRequestMail($reservation, 'client')
            );

            // Envoi au partenaire
            Mail::to($reservation->annonce->proprietaire->email)->send(
                new EvaluationRequestMail($reservation, 'partner')
            );

            // Création des entrées d'évaluation
            $reservation->evaluations()->createMany([
                [
                    'type' => 'client_to_partner',
                    'objet_id' => $reservation->annonce->objet_id,
                    'evaluateur_id' => $reservation->client_id,
                    'evalue_id' => $reservation->annonce->proprietaire_id,
                    'sent_at' => now(),
                ],
                [
                    'type' => 'partner_to_client',
                    'objet_id' => $reservation->annonce->objet_id,
                    'evaluateur_id' => $reservation->annonce->proprietaire_id,
                    'evalue_id' => $reservation->client_id,
                    'sent_at' => now(),
                ]
            ]);

            $this->info("Sent evaluation requests for reservation #{$reservation->id}");
        }

        return 0;
    }
}

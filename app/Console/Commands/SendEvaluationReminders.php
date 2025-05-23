<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Models\Evaluation;
use App\Mail\EvaluationReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendEvaluationReminders extends Command
{
    protected $signature = 'evaluations:send-reminders';
    protected $description = 'Send evaluation reminders';

    public function handle()
    {
        $reservations = Reservation::where('statut', 'terminée')
            ->where('date_fin', '>=', Carbon::now()->subWeek())
            ->whereHas('evaluations', function($q) {
                $q->whereNull('commentaire')
                  ->where('reminder_count', '<', 3);
            })
            ->with(['evaluations' => function($q) {
                $q->whereNull('commentaire');
            }, 'client', 'annonce.proprietaire'])
            ->get();

        foreach ($reservations as $reservation) {
            foreach ($reservation->evaluations as $evaluation) {
                $recipient = $evaluation->type === 'client_to_partner'
                    ? $reservation->client
                    : $reservation->annonce->proprietaire;

                Mail::to($recipient->email)->send(
                    new EvaluationReminderMail($reservation, $evaluation->type)
                );

                $evaluation->update([
                    'reminded_at' => now(),
                    'reminder_count' => $evaluation->reminder_count + 1
                ]);

                $this->info("Sent reminder for {$evaluation->type} on reservation #{$reservation->id}");
            }
        }

        return 0;
    }
}

<?php

use App\Console\Commands\SendEvaluationReminders;
use App\Console\Commands\SendEvaluationRequests;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(SendEvaluationRequests::class)->dailyAt("10:00")->timezone("Africa/Casablanca")
                ->description('Envoyer les demandes d\'évaluation aux clients et partenaires');
Schedule::command(SendEvaluationReminders::class)->dailyAt("00:56")->timezone("Africa/Casablanca")
                ->description('Envoyer les relances pour les évaluations manquantes');
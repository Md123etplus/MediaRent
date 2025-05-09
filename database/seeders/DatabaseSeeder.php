<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Categorie;
use App\Models\Objet;
use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\Evaluation;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $clients = User::factory()->count(5)->create();
        Admin::factory()->count(2)->create();
        Categorie::factory()->count(5)->create();
        Objet::factory()->count(10)->create();
        $annonces = Annonce::factory()->count(10)->create();

        // 4. Création des réservations (liées aux clients et annonces)
        $reservations = Reservation::factory()
            ->count(50)
            ->state(function (array $attributes) use ($clients, $annonces) {
                $annonce = $annonces->random();
                $faker = \Faker\Factory::create();
                return [
                    'client_id' => $clients->random()->id,
                    'annonce_id' => $annonce->id,
                    'date_debut' => $faker->dateTimeBetween(now(), now()->addDays(5)),
                    'date_fin' => $faker->dateTimeBetween(now()->addWeek(), now()->addWeek()->addDays(6)),
                    'statut' => $faker->randomElement(['confirmée', 'en_attente', 'annulée']),
                ];
            })
            ->create();

        // 5. Création des évaluations (liées aux réservations terminées)
        Evaluation::factory()
            ->count(40)
            ->state(function (array $attributes) use ($reservations, $clients) {
                $reservation = $reservations->where('statut', 'confirmée')->random();
                $objet = $reservation->annonce->objet;

                return [
                    'objet_id' => $objet->id,
                    'evaluateur_id' => $reservation->client_id,
                    'evalue_id' => $objet->proprietaire_id,
                    'date' => $reservation->date_fin->addDays(rand(1, 7)),
                ];
            })
            ->create();

        // Évaluations supplémentaires (pour varier)
        Evaluation::factory()
            ->count(10)
            ->positive()
            ->create();

        Evaluation::factory()
            ->count(5)
            ->negative()
            ->create();
    }
}

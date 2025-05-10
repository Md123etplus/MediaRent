<?php

namespace Database\Factories;

use App\Models\Annonce;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Dates aléatoires dans les 30 prochains jours
        $startDate = $this->faker->dateTimeBetween('now', '+30 days');
        $endDate = $this->faker->dateTimeBetween($startDate, '+30 days');

        // Statuts possibles
        $statuses = ['confirmée', 'en_attente', 'annulée', 'terminée'];

        return [
            'client_id' => User::where('role', 'client')->inRandomOrder()->first()->id ?? User::factory(),
            'annonce_id' => Annonce::where('statut', 'active')->inRandomOrder()->first()->id ?? Annonce::factory(),
            'date_debut' => $startDate,
            'date_fin' => $endDate,
            'statut' => $this->faker->randomElement($statuses),
        ];
    }

    /**
     * Indicate that the reservation is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'confirmée',
            ];
        });
    }

    /**
     * Indicate that the reservation is pending.
     */
    public function pending(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'en_attente',
            ];
        });
    }

    /**
     * Indicate that the reservation is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'annulée',
            ];
        });
    }

    /**
     * Indicate specific date range for the reservation.
     */
    public function betweenDates($startDate, $endDate): static
    {
        return $this->state(function (array $attributes) use ($startDate, $endDate) {
            return [
                'date_debut' => $startDate,
                'date_fin' => $endDate,
            ];
        });
    }
}

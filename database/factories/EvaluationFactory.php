<?php

namespace Database\Factories;

use App\Models\Objet;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    public function definition(): array
    {
        // Ensure evaluator and evaluatee are different users
        $evaluateur = User::inRandomOrder()->first() ?? User::factory()->create();
        $evalue = User::where('id', '!=', $evaluateur->id)
                   ->inRandomOrder()
                   ->first() ?? User::factory()->create();

        $reservation = Reservation::inRandomOrder()->first() ?? Reservation::factory()->create();
        $objet = $reservation->objet ?? Objet::factory()->create();

        return [
            'reservation_id' => $reservation->id,
            'objet_id' => $objet->id,
            'evaluateur_id' => $evaluateur->id,
            'evalue_id' => $evalue->id,
            'note_objet' => $this->faker->numberBetween(1, 5),
            'commentaire_objet' => $this->faker->paragraph,
            'note_proprietaire' => $this->faker->numberBetween(1, 5),
            'commentaire_proprietaire' => $this->faker->paragraph,
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_visible' => $this->faker->boolean(90), // 90% chance of being visible
        ];
    }

    // Custom states
    public function positive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'note_objet' => $this->faker->numberBetween(4, 5),
                'commentaire_objet' => $this->faker->randomElement([
                    'Excellent matériel, je recommande!',
                    'Très satisfait de la location',
                    'Parfait état, correspond exactement à la description'
                ]),
                'note_proprietaire' => $this->faker->numberBetween(4, 5),
                'commentaire_proprietaire' => $this->faker->randomElement([
                    'Locataire très sérieux',
                    'Excellent contact avec le propriétaire',
                    'Tout s\'est parfaitement déroulé'
                ]),
            ];
        });
    }

    public function negative(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'note_objet' => $this->faker->numberBetween(1, 2),
                'commentaire_objet' => $this->faker->randomElement([
                    'Matériel en mauvais état',
                    'Ne correspond pas à la description',
                    'Problème technique non mentionné'
                ]),
                'note_proprietaire' => $this->faker->numberBetween(1, 2),
                'commentaire_proprietaire' => $this->faker->randomElement([
                    'Problème de communication',
                    'Retard important pour la restitution',
                    'Matériel rendu dans un état dégradé'
                ]),
            ];
        });
    }

    public function forReservation(Reservation $reservation): static
    {
        return $this->state(function (array $attributes) use ($reservation) {
            return [
                'reservation_id' => $reservation->id,
                'objet_id' => $reservation->objet_id,
                'evalue_id' => $reservation->objet->proprietaire_id,
            ];
        });
    }

    public function invisible(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_visible' => false,
            ];
        });
    }
}
<?php

namespace Database\Factories;

use App\Models\Objet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    public function definition(): array
    {
        // On s'assure que l'évaluateur et l'évalué sont différents
        $evaluateur = User::inRandomOrder()->first() ?? User::factory()->create();
        $evalue = User::where('id', '!=', $evaluateur->id)
                   ->inRandomOrder()
                   ->first() ?? User::factory()->create();

        return [
            'objet_id' => Objet::inRandomOrder()->first()->id ?? Objet::factory()->create(),
            'evaluateur_id' => $evaluateur->id,
            'evalue_id' => $evalue->id,
            'note' => $this->faker->numberBetween(1, 5),
            'commentaire' => $this->faker->paragraph,
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    // States personnalisés
    public function positive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'note' => $this->faker->numberBetween(4, 5),
                'commentaire' => $this->faker->randomElement([
                    'Excellent matériel, je recommande!',
                    'Très satisfait de la location',
                    'Parfait état, correspond exactement à la description'
                ]),
            ];
        });
    }

    public function negative(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'note' => $this->faker->numberBetween(1, 2),
                'commentaire' => $this->faker->randomElement([
                    'Matériel en mauvais état',
                    'Ne correspond pas à la description',
                    'Problème technique non mentionné'
                ]),
            ];
        });
    }

    public function forObjet($objet): static
    {
        return $this->state(function (array $attributes) use ($objet) {
            return [
                'objet_id' => $objet->id,
                'evalue_id' => $objet->proprietaire_id,
            ];
        });
    }
}

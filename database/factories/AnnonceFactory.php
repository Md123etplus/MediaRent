<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Objet;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annonce>
 */
class AnnonceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_publication' => $this->faker->date(),
            'statut' => $this->faker->randomElement(['active', 'inactive']),
            'premium' => $this->faker->boolean(),
            'objet_id' => Objet::factory(), // Sélectionner un objet au hasard
            'proprietaire_id' => User::factory(), // Sélectionner un utilisateur (propriétaire) au hasard
            'date_debut' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
            'adress' => $this->faker->address(),
        ];
    }
}

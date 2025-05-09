<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Objet;
use App\Models\User;
use App\Models\Categorie;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Objet>
 */
class ObjetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'ville' => $this->faker->city(),
            'prix_journalier' => $this->faker->randomFloat(2, 10, 200),
            'etat' => $this->faker->randomElement(['neuf', 'bon', 'usé']), // adapte selon tes états réels
            'proprietaire_id' => User::factory(), // ou user existant
            'categorie_id' => Categorie::factory(), // ou catégorie existante
        ];
    }
}

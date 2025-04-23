<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'mot_de_passe' => bcrypt('password'), // ou Hash::make()
            'role' => $this->faker->randomElement([ 'partenaire', 'client']), // à ajuster selon tes rôles réels
            'CIN' => strtoupper($this->faker->bothify('??######')), // Exemple : AB123456
            'img_profil' => $this->faker->imageUrl(640, 480, 'people'),
            'img_cin_front' => $this->faker->imageUrl(640, 480, 'documents'),
            'img_cin_back' => $this->faker->imageUrl(640, 480, 'documents'),
        ];
    }
}

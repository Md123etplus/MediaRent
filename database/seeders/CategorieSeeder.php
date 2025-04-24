<?php

// database/seeders/CategorieSeeder.php
namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Outils', 'Véhicules', 'Équipement sportif', 
            'Matériel électronique', 'Vêtements', 'Autres'
        ];

        foreach ($categories as $categorie) {
            Categorie::create(['nom' => $categorie]);
        }
    }
}
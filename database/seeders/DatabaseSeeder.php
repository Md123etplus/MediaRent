<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Objet;
use App\Models\Annonce;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(5)->create();
        Categorie::factory()->count(5)->create();
        Objet::factory()->count(10)->create();
        Annonce::factory()->count(10)->create();
    }
}

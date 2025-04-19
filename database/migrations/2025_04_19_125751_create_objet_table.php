<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('objet', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description');
            $table->string('ville');
            $table->foreignId('proprietaire_id')->constrained('utilisateur');
            $table->foreignId('categorie_id')->constrained('categorie');
            $table->float('prix_journalier');
            $table->enum('etat', ['']); // Define valid etat values
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objet');
    }
};

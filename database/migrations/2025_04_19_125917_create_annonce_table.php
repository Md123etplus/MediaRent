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
        Schema::create('annonce', function (Blueprint $table) {
            $table->id();
            $table->date('date_publication');
            $table->string('statut', 50);
            $table->boolean('premium')->default(false);
            $table->foreignId('objet_id')->constrained('objet');
            $table->foreignId('proprietaire_id')->constrained(table: 'users');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->text('adress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonce');
    }
};

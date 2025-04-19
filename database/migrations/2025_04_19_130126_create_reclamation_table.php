<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reclamation', function (Blueprint $table) {
            $table->id();
            $table->text('contenu');
            $table->foreignId('utilisateur_id')->constrained('utilisateur');
            $table->foreignId('reservation_id')->constrained('reservation');
            $table->dateTime('date_creation')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('statut', 50)->nullable()->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclamation');
    }
};

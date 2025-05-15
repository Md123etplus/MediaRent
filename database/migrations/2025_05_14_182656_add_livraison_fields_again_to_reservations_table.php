<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('reservation', function (Blueprint $table) {
            $table->boolean('livraison')->default(false);
            $table->decimal('frais_livraison', 10, 2)->nullable();
            $table->text('adresse_livraison')->nullable();
            $table->string('statut_livraison')->nullable();
            $table->decimal('commission_entreprise', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('reservation', function (Blueprint $table) {
            $table->dropColumn(['livraison', 'frais_livraison', 'adresse_livraison', 'statut_livraison', 'commission_entreprise']);
        });
    }
};

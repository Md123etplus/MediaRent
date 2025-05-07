<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('evaluation', function (Blueprint $table) {
            // Renommer les colonnes existantes
            $table->renameColumn('note', 'note_objet');
            $table->renameColumn('commentaire', 'commentaire_objet');
            
            // Ajouter les nouvelles colonnes
            $table->integer('note_proprietaire')->after('note_objet');
            $table->text('commentaire_proprietaire')->after('commentaire_objet');
            $table->unsignedBigInteger('reservation_id')->after('id');
            
            // Ajouter les contraintes de clé étrangère
            $table->foreign('reservation_id')->references('id')->on('reservations');
        });
    }

    public function down()
    {
        Schema::table('evaluation', function (Blueprint $table) {
            // Supprimer les contraintes
            $table->dropForeign(['reservation_id']);
            
            // Re-renommer les colonnes à leur état original
            $table->renameColumn('note_objet', 'note');
            $table->renameColumn('commentaire_objet', 'commentaire');
            
            // Supprimer les colonnes ajoutées
            $table->dropColumn(['note_proprietaire', 'commentaire_proprietaire', 'reservation_id']);
        });
    }
};
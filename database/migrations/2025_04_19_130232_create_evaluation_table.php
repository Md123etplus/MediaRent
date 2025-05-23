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
        Schema::create('evaluation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objet_id')->constrained(table: 'objet'); // Possible schema error
            $table->foreignId('evaluateur_id')->constrained('users');
            $table->foreignId('evalue_id')->constrained('users');
            $table->integer('note')->default(0);
            $table->text('commentaire')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->date('date')->nullable();
            $table->enum('type', ['client_to_partner', 'partner_to_client', 'objet_evaluation'])->default('client_to_partner');
            $table->boolean('is_public')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('reminded_at')->nullable();
            $table->integer('reminder_count')->default(0);
            $table->unsignedBigInteger('reservation_id');
            // Ajouter les contraintes de clé étrangère
            $table->foreign('reservation_id')->references('id')->on('reservation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation');
    }
};

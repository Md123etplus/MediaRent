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
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->text('contenu');
            $table->text('contenu_email');
            $table->string('sujet_email');
            $table->foreignId('utilisateur_id')->constrained(table: 'users');
            $table->foreignId('annonce_id')->nullable()->constrained('annonce');
            $table->dateTime('date_creation')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('envoyee')->default(false);
            $table->boolean('lue')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};

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
            $table->foreignId('objet_id')->constrained('reservation'); // Possible schema error
            $table->foreignId('evaluateur_id')->constrained('users');
            $table->foreignId('evalue_id')->constrained('users');
            $table->integer('note');
            $table->text('commentaire');
            $table->date('date');
            $table->enum('type', ['client_to_partner', 'partner_to_client'])->default('client_to_partner')->after('id');
            $table->boolean('is_public')->default(false)->after('commentaire');
            $table->timestamp('sent_at')->nullable()->after('is_public');
            $table->timestamp('reminded_at')->nullable()->after('sent_at');
            $table->integer('reminder_count')->default(0)->after('reminded_at');
            $table->foreignId('reservation_id')->constrained()->after('objet_id');
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

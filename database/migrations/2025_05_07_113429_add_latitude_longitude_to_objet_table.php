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
         Schema::table('objet', function (Blueprint $table) {
             $table->decimal('latitude', 10, 7)->nullable()->after('ville');
             $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
             $table->index(['latitude', 'longitude']); // Pour les requêtes spatiales
         });
     }
     
     public function down()
     {
         Schema::table('objet', function (Blueprint $table) {
             $table->dropColumn(['latitude', 'longitude']);
         });
     }
};

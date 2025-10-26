<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneCommandeLunchPrestataireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_commande_lunch_prestataire', function (Blueprint $table) {
            $table->id();
            $table->integer('prestataire_id');
            $table->string('prestataire_name');
            $table->string('prestataire_adresse')->nullable();
            $table->string('prestataire_ville')->nullable();
            $table->string('prestataire_code_postal')->nullable();
            $table->string('prestataire_phone')->nullable();
            $table->string('prestataire_email')->nullable();
            $table->string('prestataire_second_email')->nullable(); 
            $table->string('model');
            $table->integer('model_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligne_commande_lunch_prestataire');
    }
}

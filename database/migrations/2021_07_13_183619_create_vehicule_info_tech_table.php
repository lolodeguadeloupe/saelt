<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculeInfoTechTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicule_info_tech', function (Blueprint $table) {
            $table->id();
            $table->integer('nombre_place');
            $table->integer('nombre_porte');
            $table->string('vitesse_maxi')->nullable();
            $table->string('nombre_vitesse')->nullable();
            $table->string('boite_vitesse')->nullable();
            $table->string('annee_sortir')->nullable();
            $table->string('kilometrage')->nullable();
            $table->string('type_carburant');
            $table->longText('fiche_technique')->nullable();
            $table->foreignId('vehicule_id')->constrained('vehicule_location')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('vehicule_info_tech');
    }
}

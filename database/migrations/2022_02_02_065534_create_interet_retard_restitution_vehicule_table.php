<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteretRetardRestitutionVehiculeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interet_retard_restitution_vehicule', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('duree_retard')->nullable();
            $table->float('valeur_pourcent')->default(0.0);
            $table->float('valeur_devises')->default(0.0);
            $table->string('valeur_appliquer');
            $table->longText('descciption')->nullable();
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
        Schema::dropIfExists('interet_retard_restitution_vehicule');
    }
}

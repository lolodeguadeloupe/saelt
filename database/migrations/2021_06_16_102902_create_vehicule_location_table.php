<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculeLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicule_location', function (Blueprint $table) {
            $table->id();
             $table->string('titre')->nullable();
            $table->string('immatriculation');
            $table->integer('status')->default(0);
            $table->text('description')->nullable();
            $table->integer('duration_min')->default(0);
            $table->float('franchise')->default(0)->nullable();
            $table->float('franchise_non_rachatable')->default(0)->nullable();
            $table->float('caution')->default(0)->nullable();
            $table->string('entite_modele')->default('location_vehicule');
            $table->foreignId('marque_vehicule_id')->constrained('marque_vehicule')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('modele_vehicule_id')->constrained('modele_vehicule')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('prestataire_id')->constrained('prestataire')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('categorie_vehicule_id')->constrained('categorie_vehicule')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('vehicule_location');
    }
}

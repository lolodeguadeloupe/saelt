<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestrictionTrajetVehiculeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restriction_trajet_vehicule', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->foreignId('agence_location_depart')->constrained('agence_location')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('agence_location_arrive')->constrained('agence_location')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('restriction_trajet_vehicule');
    }
}

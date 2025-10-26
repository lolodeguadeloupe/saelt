<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculeCategorieSupplementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicule_categorie_supplement', function (Blueprint $table) {
            $table->id();
            $table->float('tarif')->default(0);
            $table->foreignId('restriction_trajet_id')->constrained('restriction_trajet_vehicule')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('vehicule_categorie_supplement');
    }
}

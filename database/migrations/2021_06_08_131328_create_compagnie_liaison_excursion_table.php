<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompagnieLiaisonExcursionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compagnie_liaison_excursion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('excursion_id')->constrained('excursions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('compagnie_transport_id')->constrained('compagnie_transport')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('compagnie_liaison_excursion');
    }
}

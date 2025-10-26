<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranchePersonneTransfertVoyageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tranche_personne_transfert_voyage', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->integer('nombre_min');
            $table->integer('nombre_max');
            $table->foreignId('type_transfert_id')->constrained('type_transfert_voyage')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tranche_personne_transfert_voyage');
    }
}

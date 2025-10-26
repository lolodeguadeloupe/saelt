<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrancheSaisonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tranche_saison', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('titre');
            $table->integer('nombre_min');
            $table->integer('nombre_max');
            $table->string('model')->nullable();
            $table->integer('model_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tranche_saison');
    }
}

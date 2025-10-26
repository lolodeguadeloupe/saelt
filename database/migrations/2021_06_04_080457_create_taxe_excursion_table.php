<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxeExcursionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxe_excursion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarif_excursion_id')->constrained('tarif_excursion')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('taxe_id')->constrained('taxe')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('taxe_excursion');
    }
}

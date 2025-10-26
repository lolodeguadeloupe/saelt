<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInclusSupplementExcursionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inclus_supplement_excursion', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('tarif_excursion_id')->constrained('tarif_excursion')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('supplement_excursion_id')->constrained('supplement_excursion')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('inclus_supplement_excursion');
    }
}

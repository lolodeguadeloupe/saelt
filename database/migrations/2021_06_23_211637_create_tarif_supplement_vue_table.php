<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifSupplementVueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif_supplement_vue', function (Blueprint $table) {
            $table->id();
             $table->float('prix_achat')->default(0);
            $table->float('marge')->default(0);
             $table->float('prix_vente')->default(0);
            $table->foreignId('supplement_id')->constrained('supplement_vue')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tarif_supplement_vue');
    }
}

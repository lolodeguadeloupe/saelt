<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifSupplementPensionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif_supplement_pension', function (Blueprint $table) {
            $table->id();
             $table->float('prix_achat')->default(0);
            $table->float('marge')->default(0);
             $table->float('prix_vente')->default(0);
            $table->foreignId('type_personne_id')->constrained('type_personne')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('supplement_id')->constrained('supplement_pension')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tarif_supplement_pension');
    }
}

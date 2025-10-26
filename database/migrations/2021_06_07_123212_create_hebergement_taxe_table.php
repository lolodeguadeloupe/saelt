<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHebergementTaxeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hebergement_taxe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hebergement_id')->constrained('hebergements')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hebergement_taxe');
    }
}

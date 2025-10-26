<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcursionTaxeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excursion_taxe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('excursion_id')->constrained('excursions')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('excursion_taxe');
    }
}

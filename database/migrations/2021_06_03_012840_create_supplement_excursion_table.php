<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplementExcursionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplement_excursion', function (Blueprint $table) {
            $table->id();
            $table->string('titre'); 
            $table->string('type');
            $table->string('description')->nullable();
            $table->longText('icon')->nullable();
            $table->foreignId('prestataire_id')->nullable()->constrained('prestataire')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('excursion_id')->constrained('excursions')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('supplement_excursion');
    }
}

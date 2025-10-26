<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHebergementMarqueBlancheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hebergement_marque_blanche', function (Blueprint $table) {
            $table->id();
            $table->string('liens');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('type_hebergement_id')->constrained('type_hebergement')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hebergement_marque_blanche');
    }
}

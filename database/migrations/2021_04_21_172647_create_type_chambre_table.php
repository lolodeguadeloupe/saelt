<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeChambreTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('type_chambre', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('nombre_chambre')->default(1);
            $table->integer('nombre_adulte_max')->default(0)->nullable();
            $table->double('cout_supplementaire')->nullable();
            $table->text('image')->nullable();
            $table->string('status')->default(1);
            $table->integer('capacite')->default(0);
            $table->integer('formule')->nullable();
            $table->foreignId('hebergement_id')->constrained('hebergements')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('type_chambre');
    }

}

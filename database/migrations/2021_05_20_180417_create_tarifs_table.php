<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tarifs', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->string('description')->nullable();
            $table->float('marge')->default(0.0);
            $table->integer('taxe_active')->default(0);
            $table->float('taxe')->default(0.0);
            $table->integer('jour_min')->nullable();
            $table->integer('jour_max')->nullable();
            $table->integer('nuit_min')->nullable();
            $table->integer('nuit_max')->nullable();
            $table->foreignId('type_chambre_id')->constrained('type_chambre')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('hebergement_id')->constrained('hebergements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('base_type_id')->nullable()->constrained('base_type')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tarifs');
    }

}

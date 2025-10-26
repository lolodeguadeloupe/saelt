<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHebergementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hebergements', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('image')->nullable();
            $table->longText('fond_image')->nullable();
            $table->text('description')->nullable();
            $table->string('adresse');
            $table->integer('duration_min')->nullable();
            $table->string('status')->default(1);
            $table->float('caution')->default(0.0)->nullable();
            $table->string('heure_ouverture')->default("00:00")->nullable();
            $table->string('heure_fermeture')->default("00:00")->nullable();
            $table->integer('etoil')->nullable();
            $table->foreignId('type_hebergement_id')->constrained('type_hebergement')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('ville_id')->constrained('villes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('ile_id')->constrained('iles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('prestataire_id')->constrained('prestataire')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hebergements');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneCommandeSupplementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_commande_supplement', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('icon')->nullable();
            $table->string('regle_tarif');
            $table->double('prix')->default('0.0')->nullable();
            $table->string('ligne_commande_model');
            $table->integer('ligne_commande_id');
            /** */
            $table->integer('prestataire_id');
            $table->string('prestataire_name');
            $table->string('prestataire_adresse')->nullable();
            $table->string('prestataire_ville')->nullable();
            $table->string('prestataire_code_postal')->nullable();
            $table->string('prestataire_phone')->nullable();
            $table->string('prestataire_email')->nullable();
            $table->string('prestataire_second_email')->nullable();
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
        Schema::dropIfExists('ligne_commande_supplement');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneCommandeTypePersonneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_commande_type_personne', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('age');
            $table->integer('nb');
            $table->double('prix_unitaire')->default('0.0')->nullable();
            $table->double('prix_total')->default('0.0')->nullable();
            $table->string('ligne_commande_model');
            $table->integer('ligne_commande_id');
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
        Schema::dropIfExists('ligne_commande_type_personne');
    }
}

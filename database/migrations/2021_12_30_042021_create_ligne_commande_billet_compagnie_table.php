<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneCommandeBilletCompagnieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_commande_billet_compagnie', function (Blueprint $table) {
            $table->id();
            $table->string("compagnie_id");
            $table->string("compagnie_nom");
            $table->string("compagnie_email")->nullable();
            $table->string("compagnie_phone")->nullable();
            $table->string("compagnie_adresse")->nullable();
            $table->string("compagnie_ville")->nullable();
            $table->string("compagnie_code_postal")->nullable();
            $table->string('billet_id');
            $table->string('billet_titre');
            $table->date('billet_date_depart')->nullable();
            $table->date('billet_date_arrive')->nullable();
            $table->string('billet_lieu_depart_id')->nullable();
            $table->string('billet_lieu_arrive_id')->nullable();
            $table->string('billet_lieu_depart_name')->nullable();
            $table->string('billet_lieu_arrive_name')->nullable();
            $table->string('billet_lieu_depart_ville')->nullable();
            $table->string('billet_lieu_arrive_ville')->nullable();
            $table->string('billet_lieu_depart_code_postal')->nullable();
            $table->string('billet_lieu_arrive_code_postal')->nullable();
                        
            $table->string('model');
            $table->integer('model_id');
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
        Schema::dropIfExists('ligne_commande_billet_compagnie');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneVolHebergementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_vol_hebergement', function (Blueprint $table) {
            $table->id();
            $table->string('ligne_commande_model');
            $table->integer('ligne_commande_id');
            $table->date("depart");
            $table->date("arrive");
            $table->float("nombre_jour");
            $table->integer("nombre_nuit");
            $table->time("heure_depart");
            $table->time("heure_arrive");
            /* */
            $table->string('allotement_id')->nullable();
            $table->string("titre");
            $table->string('compagnie_transport_id')->nullable();
            $table->string('lieu_depart_id')->nullable();
            $table->string('lieu_depart')->nullable();
            $table->string('lieu_arrive_id')->nullable();
            $table->string('lieu_arrive')->nullable();
            //
            $table->string("compagnie_nom");
            $table->string("compagnie_email")->nullable();
            $table->string("compagnie_phone")->nullable();
            $table->string("compagnie_adresse");
            $table->longText('compagnie_logo')->nullable();
            $table->string('type_transport');
            $table->string('compagnie_heure_ouverture')->nullable();
            $table->string('compagnie_heure_fermeture')->nullable();
            $table->string('compagnie_ville_id')->nullable();
            $table->string('compagnie_ville_name')->nullable();
            $table->string('compagnie_ville_code_postal')->nullable();
            //

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
        Schema::dropIfExists('ligne_vol_hebergement');
    }
}

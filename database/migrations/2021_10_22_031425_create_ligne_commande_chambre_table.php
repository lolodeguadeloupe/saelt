<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneCommandeChambreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_commande_chambre', function (Blueprint $table) {
            $table->id();
            $table->string('hebergement_id')->nullable();
            $table->string('hebergement_name')->nullable();
            $table->string('hebergement_type')->nullable();
            $table->integer('hebergement_duration_min')->nullable();
            $table->float('hebergement_caution')->default(0.0)->nullable();
            $table->integer('hebergement_etoil')->nullable();
            /* */
            $table->string('chambre_id');
            $table->string('chambre_name');
            $table->text('chambre_image')->nullable();
            $table->integer('chambre_capacite')->default(0);
            $table->string('chambre_base_type_titre');
            $table->string('chambre_base_type_nombre');
            $table->string('ticket_compagnie_id')->nullable();
            /* */
            $table->integer('quantite_chambre');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->double('prix_unitaire')->default('0.0')->nullable();
            $table->double('prix_total')->default('0.0')->nullable();
            $table->foreignId('commande_id')->constrained('commande')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            /* */
            $table->foreignId('ville_id')->constrained('villes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('ile_id')->constrained('iles')->onDelete('cascade')->onUpdate('cascade');
            $table->string('prestataire_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligne_commande_chambre');
    }
}

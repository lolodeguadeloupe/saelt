<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneCommandeLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_commande_location', function (Blueprint $table) {
            $table->id();
            $table->string('location_id');
            $table->string('titre')->nullable();
            $table->string('immatriculation');
            $table->integer('duration_min')->default(0);
            $table->float('franchise')->default(0)->nullable();
            $table->float('franchise_non_rachatable')->default(0)->nullable();
            $table->float('caution')->default(0)->nullable();
            $table->longText('image')->nullable();
            /** */
            $table->string('marque_vehicule_id');
            $table->string('marque_vehicule_titre');
            $table->string('modele_vehicule_id');
            $table->string('modele_vehicule_titre');
            $table->string('categorie_vehicule_id');
            $table->string('categorie_vehicule_titre');
            $table->string('famille_vehicule_id');
            $table->string('famille_vehicule_titre');
            $table->string('prestataire_id')->nullable();
            /** */
            $table->string('agence_recuperation_name');
            $table->string('agence_recuperation_id');
            $table->string('agence_restriction_name');
            $table->string('agence_restriction_id');
            $table->date('date_recuperation');
            $table->date('date_restriction');
            $table->string('heure_recuperation');
            $table->string('heure_restriction');
            /* */
            $table->string('nom_conducteur');
            $table->string('prenom_conducteur');
            $table->string('adresse_conducteur');
            $table->string('ville_conducteur');
            $table->string('code_postal_conducteur');
            $table->string('telephone_conducteur');
            $table->string('email_conducteur');
            $table->string('date_naissance_conducteur');
            $table->string('lieu_naissance_conducteur');
            $table->string('num_permis_conducteur');
            $table->string('date_permis_conducteur');
            $table->string('lieu_deliv_permis_conducteur');
            $table->string('num_identite_conducteur');
            $table->string('date_emis_identite_conducteur');
            $table->string('lieu_deliv_identite_conducteur');
            $table->string('order_comments')->nullable();
            /* */
            $table->double('prix_unitaire')->default('0.0')->nullable();
            $table->double('prix_total')->default('0.0')->nullable();
            $table->foreignId('commande_id')->constrained('commande')->onDelete('cascade')->onUpdate('cascade');
            $table->double('deplacement_lieu_tarif')->default('0.0')->nullable();
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
        Schema::dropIfExists('ligne_commande_location');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneCommandeTransfertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_commande_transfert', function (Blueprint $table) {
            $table->id();
            $table->integer('transfert_id');
            $table->string('titre');
            $table->date('date_depart')->nullable();
            $table->date('date_retour')->nullable();
            $table->longText('image')->nullable();
            $table->integer('quantite')->default(0);
            $table->string('lieu_depart_id');
            $table->string('lieu_depart_name');
            $table->string('lieu_arrive_id');
            $table->string('lieu_arrive_name'); 
            $table->string('prestataire_id')->nullable();
            /* */
            $table->integer('parcours');
            $table->string('heure_depart')->nullable();
            $table->string('heure_retour')->nullable();
            $table->double('prime_depart')->default('0.0')->nullable();
            $table->double('prime_retour')->default('0.0')->nullable();
            /* */
            $table->double('prix_unitaire')->default('0.0')->nullable();
            $table->double('prix_total')->default('0.0')->nullable();
            $table->foreignId('commande_id')->constrained('commande')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('ligne_commande_transfert');
    }
}

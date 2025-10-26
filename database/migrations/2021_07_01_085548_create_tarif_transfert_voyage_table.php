<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifTransfertVoyageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif_transfert_voyage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trajet_transfert_voyage_id')->constrained('trajet_transfert_voyage')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tranche_transfert_voyage_id')->constrained('tranche_personne_transfert_voyage')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_personne_id')->constrained('type_personne')->onDelete('cascade')->onUpdate('cascade');
            $table->float('prix_achat_aller')->default(0);
            $table->float('prix_achat_aller_retour')->default(0);
            $table->float('marge_aller')->default(0);
            $table->float('marge_aller_retour')->default(0);
            $table->float('prix_vente_aller')->default(0);
            $table->float('prix_vente_aller_retour')->default(0);
            $table->float('prime_nuit')->default(0)->nullable();
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
        Schema::dropIfExists('tarif_transfert_voyage');
    }
}

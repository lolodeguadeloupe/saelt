<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifTrancheSaisonLocationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tarif_tranche_saison_location', function (Blueprint $table) {
            $table->id();
            $table->float('marge')->default(0);
            $table->float('prix_achat');
            $table->float('prix_vente');
            $table->foreignId('tranche_saison_id')->constrained('tranche_saison')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('vehicule_location_id')->constrained('vehicule_location')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('saisons_id')->constrained('saisons')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tarif_tranche_saison_location');
    }

}

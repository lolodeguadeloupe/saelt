<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifTypePersonneHebergementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif_type_personne_hebergement', function (Blueprint $table) {
            $table->id();
            $table->float('prix_achat')->default(0);
            $table->float('marge')->default(0);
            $table->float('prix_vente')->default(0);
            /** */
            $table->float('prix_achat_supp')->default(0)->nullable();
            $table->float('marge_supp')->default(0)->nullable();
            $table->float('prix_vente_supp')->default(0)->nullable();
            /** */
            $table->foreignId('type_personne_id')->constrained('type_personne')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tarif_id')->constrained('tarifs')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tarif_type_personne_hebergement');
    }
}

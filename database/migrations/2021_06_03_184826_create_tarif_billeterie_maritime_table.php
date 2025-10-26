<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifBilleterieMaritimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif_billeterie_maritime', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billeterie_maritime_id')->constrained('billeterie_maritime')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_personne_id')->constrained('type_personne')->onDelete('cascade')->onUpdate('cascade');
            $table->string('prix_achat_aller')->default('0');
            $table->string('prix_achat_aller_retour')->default('0')->nullable();
            $table->float('marge_aller')->default(0);
            $table->float('marge_aller_retour')->default(0)->nullable();
            $table->string('prix_vente_aller')->default('0');
            $table->string('prix_vente_aller_retour')->default('0')->nullable();
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
        Schema::dropIfExists('tarif_billeterie_maritime');
    }
}

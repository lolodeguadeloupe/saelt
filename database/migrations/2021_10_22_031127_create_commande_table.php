<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commande', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('status')->default('0');
            $table->string('status_payement')->default('0');
            $table->double('prix')->default('0.0')->nullable();
            $table->double('tva')->default('0.0')->nullable();
            $table->double('frais_dossier')->default('0.0')->nullable();
            $table->double('prix_total')->default('0.0')->nullable();
            $table->integer('mode_payement_id')->nullable();
            $table->string('paiement_id')->nullable();
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
        Schema::dropIfExists('commande');
    }
}

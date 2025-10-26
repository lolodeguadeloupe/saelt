<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChambreEnCommandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chambre_en_commande', function (Blueprint $table) {
            $table->id();
            $table->integer('nombre')->nullable()->default(0);
            $table->integer('chambre_id');
            $table->text('session_id');
            $table->text('commande_id');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->date('date');
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
        Schema::dropIfExists('chambre_en_commande');
    }
}

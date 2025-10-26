<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHebergementVolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hebergement_vol', function (Blueprint $table) {
            $table->id();
            $table->date("depart");
            $table->date("arrive");
            $table->float("nombre_jour");
            $table->integer("nombre_nuit");
            $table->time("heure_depart");
            $table->time("heure_arrive");
            $table->foreignId('tarif_id')->constrained('tarifs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('allotement_id')->nullable()->constrained('allotements')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hebergement_vol');
    }
}

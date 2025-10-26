<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllotementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allotements', function (Blueprint $table) {
            $table->id();
            $table->string("titre");
            $table->integer("quantite")->default(0);
            $table->date("date_depart");
            $table->date("date_arrive");
            $table->date("date_acquisition");
            $table->date("date_limite")->nullable();
            $table->time("heure_depart")->nullable();
            $table->time("heure_arrive")->nullable();
            $table->foreignId('compagnie_transport_id')->constrained('compagnie_transport')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lieu_depart_id')->constrained('service_aeroport')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lieu_arrive_id')->constrained('service_aeroport')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('allotements');
    }
}

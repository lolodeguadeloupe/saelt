<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBilleterieMaritimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billeterie_maritime', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->date('date_depart')->nullable();
            $table->date('date_arrive')->nullable();
            $table->string('availability')->nullable();
            $table->integer('parcours')->default(1)->nullable();
            $table->date('date_acquisition');
            $table->date('date_limite')->nullable();
            $table->longText('image')->nullable();
            $table->integer('quantite')->default(0); 
            $table->time('duree_trajet')->default(0)->nullable();
            $table->foreignId('compagnie_transport_id')->constrained('compagnie_transport')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lieu_depart_id')->constrained('service_port')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lieu_arrive_id')->constrained('service_port')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('billeterie_maritime');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVehiculeTransfertVoyageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicule_transfert_voyage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_transfert_voyage_id')->constrained('type_transfert_voyage')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('vehicule_id')->constrained('vehicule_location')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        /*DB::unprepared('CREATE TRIGGER after_vehicule_transfert_voyage_delete
         AFTER DELETE ON vehicule_transfert_voyage FOR EACH ROW 
         DELETE FROM vehicule_location WHERE vehicule_location.id = old.vehicule_id;');*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicule_transfert_voyage');
        /* DB::statement('DROP TRIGGER IF EXISTS `after_vehicule_transfert_voyage_delete`;');*/
    }
}

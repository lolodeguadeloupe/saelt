<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateConducteurSupplemetaireLocationVehiculeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conducteur_supplemetaire_location_vehicule', function (Blueprint $table) {
            $table->id();
            $table->string('sigle');
            $table->float('valeur_pourcent')->default(0.0);
            $table->float('valeur_devises')->default(0.0);
            $table->string('valeur_appliquer');
            $table->timestamps();
        });

        DB::statement("INSERT INTO `conducteur_supplemetaire_location_vehicule` (`id` ,`sigle`, `valeur_pourcent`,`valeur_devises`,`valeur_appliquer`, `created_at`, `updated_at`) VALUES
        (1,'conducteur_supplementaire','0.0','0.0','0','2021-08-05 08:29:07', '2021-12-21 04:41:18');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conducteur_supplemetaire_location_vehicule');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateModeleVehiculeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modele_vehicule', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        DB::statement("INSERT INTO `modele_vehicule` (`id`, `titre`, `description`, `created_at`, `updated_at`) VALUES
        (1, 'Model 1', NULL, '2021-08-05 17:55:23', '2021-08-05 17:55:23');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modele_vehicule');
    }
}

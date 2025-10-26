<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMarqueVehiculeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marque_vehicule', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO `marque_vehicule` (`id`, `titre`, `description`, `created_at`, `updated_at`) VALUES
        (1, 'Marque 1', NULL, '2021-08-05 17:55:04', '2021-08-05 17:55:04');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marque_vehicule');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFamilleVehiculeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('famille_vehicule', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO `famille_vehicule` (`id`, `titre`, `description`, `created_at`, `updated_at`) VALUES
        (1, 'Famille 1', NULL, '2021-08-05 17:55:45', '2021-08-05 17:55:45'),
        (2, 'Famille 2', NULL, '2021-08-13 18:51:43', '2021-08-13 18:51:43');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('famille_vehicule');
    }
}

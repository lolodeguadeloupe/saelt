<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->timestamps();
        });

        DB::statement("INSERT INTO `pays` (`id`, `nom`, `created_at`, `updated_at`) VALUES
        (1, 'Pays 1', '2021-08-05 08:29:07', '2021-12-21 04:41:18'),
        (2, 'Pays2', '2021-08-31 14:48:51', '2021-08-31 14:48:51'),
        (3, 'Les Saintes', '2021-09-09 19:15:47', '2021-09-09 19:15:47'),
        (4, 'Guadeloupe', '2021-09-28 01:48:34', '2021-09-28 01:48:34'),
        (5, 'Madagascar', '2021-11-26 02:27:42', '2021-11-26 02:27:42'),
        (9, 'La Désirade', '2021-11-30 06:58:35', '2021-11-30 06:58:35'),
        (12, 'Marie-Galante', '2021-11-30 07:04:07', '2021-11-30 07:04:07'),
        (13, 'France', '2022-01-08 14:30:29', '2022-01-08 14:30:29');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pays');
    }
}

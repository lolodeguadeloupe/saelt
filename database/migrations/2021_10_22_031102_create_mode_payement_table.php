<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateModePayementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mode_payement', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('icon')->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO `mode_payement` (`id`, `titre`, `icon`, `created_at`, `updated_at`) VALUES
        (7, 'Alma', 'images/alma logo.jpg', '2021-11-24 09:26:05', '2021-11-24 09:26:05');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mode_payement');
    }
}

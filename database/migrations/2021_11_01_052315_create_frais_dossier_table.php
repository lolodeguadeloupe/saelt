<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFraisDossierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frais_dossier', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->string('sigle')->nullable();
            $table->double('prix')->default('0.0')->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO `frais_dossier` (`id`,`titre`, `sigle`, `prix`, `created_at`, `updated_at`) VALUES
        (1, 'Frais de dossier en ligne','frais_internet', '20', '2021-11-30 10:04:07', '2021-11-30 10:04:07'),
        (2, 'Frais de dossier à l agence','frais_agence','20', '2021-11-30 10:04:07', '2021-11-30 10:04:07');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frais_dossier');
    }
}

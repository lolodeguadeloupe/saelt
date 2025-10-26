<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAgenceLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agence_location', function (Blueprint $table) {
            $table->id();
            $table->string('code_agence')->nullable();
            $table->string('name');
            $table->string('adresse')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->longText('logo')->nullable();
            $table->string('heure_ouverture')->default("00:00")->nullable();
            $table->string('heure_fermeture')->default("23:59")->nullable();
            $table->foreignId('ville_id')->constrained('villes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::statement("INSERT INTO `agence_location` (`id`, `code_agence`, `name`, `adresse`, `phone`, `email`, `logo`, `heure_ouverture`, `heure_fermeture`, `ville_id`, `created_at`, `updated_at`) VALUES
        (1, '', 'Gare de Bergevin', 'Antananarivo', '0328565583', 'Administrator@brackets.sk', NULL, '12:00', '19:20', 1, '2021-08-16 10:57:24', '2021-10-06 16:50:02'),
        (2, '', 'Agence 1', NULL, NULL, NULL, NULL, '00:00', '23:59', 1, '2021-10-06 23:25:01', '2021-10-21 14:36:53'),
        (3, '', 'Agence 2', NULL, NULL, NULL, NULL, '00:00', '23:59', 1, '2021-10-06 23:25:20', '2021-10-21 14:36:48'),
        (4, '', 'Basse terre', 'Basse terre', NULL, NULL, NULL, '00:00', '23:59', 21, '2021-10-21 09:57:56', '2021-10-21 10:04:49');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agence_location');
    }
}

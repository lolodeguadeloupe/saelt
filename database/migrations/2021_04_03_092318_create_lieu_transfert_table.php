<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLieuTransfertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lieu_transfert', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('adresse')->nullable();
            $table->foreignId('ville_id')->nullable()->constrained('villes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::statement("INSERT INTO `lieu_transfert` (`id`, `titre`, `adresse`, `ville_id`, `created_at`, `updated_at`) VALUES
        (1,	'Aéroport Pôle Caraïbes',	'Aéroport Pôle Caraïbes',	1,	'2021-08-06 13:23:45',	'2021-08-06 13:26:01'),
        (2,	'Saint-françois',	'Saint-françois',	1,	'2021-08-06 13:26:18',	'2021-08-06 13:26:18'),
        (3,	'Lieu 5',	'Antananarivo',	1,	'2021-11-26 04:14:57',	'2021-11-26 04:14:57'),
        (4,	'Sainte-Anne',	NULL,	24,	'2022-01-06 12:59:45',	'2022-01-06 12:59:45'),
        (5,	'Deshaies',	NULL,	33,	'2022-01-06 13:01:37',	'2022-01-06 13:01:37'),
        (6,	'Aéroport pôle caraïbes <=> sainte-anne',	NULL,	24,	'2022-01-06 13:04:24',	'2022-01-06 13:04:24'),
        (7,	'Trois-Rivières',	NULL,	27,	'2022-01-06 13:23:02',	'2022-01-06 13:23:02'),
        (8,	'Le Gosier',	NULL,	34,	'2022-01-06 13:23:40',	'2022-01-06 13:23:40'),
        (9,	'Sainte-Anne',	'Adresse',	1,	'2022-01-07 12:16:55',	'2022-01-07 12:16:55');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lieu_transfert');
    }
}

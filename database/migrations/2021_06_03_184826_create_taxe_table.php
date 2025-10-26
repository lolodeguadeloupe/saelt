<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTaxeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxe', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('sigle')->nullable();
            $table->integer('taxe_appliquer')->default(0);
            $table->float('valeur_pourcent')->default(0.0);
            $table->float('valeur_devises')->default(0.0);
            $table->longText('descciption')->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO `taxe` (`id`, `titre`, `sigle`, `taxe_appliquer`, `valeur_pourcent`, `valeur_devises`, `descciption`, `created_at`, `updated_at`) VALUES
        (1,	'TVA sur les Transferts',	'tva_transfert',	0,	2.10,	0.00,	NULL,	'2022-01-13 09:07:23',	'2022-01-13 09:09:10'),
        (2,	'TVA sur les excursions',	'tva_excursion',	0,	2.10,	0.00,	NULL,	'2022-01-13 09:08:22',	'2022-01-13 09:09:16'),
        (3,	'TVA sur les hebergements et package',	'tva_hebergement_pack',	0,	8.50,	0.00,	NULL,	'2022-01-13 09:09:33',	'2022-01-14 05:05:13'),
        (4,	'TVA sur la location',	'Tva_location',	1,	0.00,	8.50,	NULL,	'2022-01-14 05:05:48',	'2022-01-14 05:05:48'),
        (5,	'TVA sur la billeterie',	'Tva_billetterie',	1,	0.00,	8.50,	NULL,	'2022-01-14 05:05:54',	'2022-01-14 05:05:54');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxe');
    }
}

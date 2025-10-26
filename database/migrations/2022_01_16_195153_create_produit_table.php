<?php

use App\Models\BilleterieMaritime;
use App\Models\Excursion\Excursion;
use App\Models\Hebergement\Hebergement;
use App\Models\LocationVehicule\VehiculeLocation;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit', function (Blueprint $table) {
            $table->id();
            $table->string('sigle');
            $table->string('model')->nullable();
            $table->integer('status');
            $table->timestamps();
        });

        DB::statement("INSERT INTO `produit` (`id`, `sigle` , `model`,`status`, `created_at`, `updated_at`) VALUES
        (1,'hebergement','" . Hebergement::class . "',1,'2021-08-05 08:29:07', '2021-12-21 04:41:18'),
        (2,'excursion','" . Excursion::class . "',1,'2021-08-05 08:29:07', '2021-12-21 04:41:18'),
        (3,'transfert','" . TypeTransfertVoyage::class . "',1,'2021-08-05 08:29:07', '2021-12-21 04:41:18'),
        (4,'location','" . VehiculeLocation::class . "',1,'2021-08-05 08:29:07', '2021-12-21 04:41:18'),
        (5,'billetterie','" . BilleterieMaritime::class . "',1,'2021-08-05 08:29:07', '2021-12-21 04:41:18');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produit');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfertVoyagePrimeNuitTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transfert_voyage_prime_nuit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trajet_id')->constrained('trajet_transfert_voyage')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_transfert_id')->constrained('type_transfert_voyage')->onDelete('cascade')->onUpdate('cascade');
            $table->float('prime_nuit')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('transfert_voyage_prime_nuit');
    }

}

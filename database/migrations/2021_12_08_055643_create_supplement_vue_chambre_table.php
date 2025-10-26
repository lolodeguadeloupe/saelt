<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplementVueChambreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplement_vue_chambre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplement_vue_id')->constrained('supplement_vue')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_chambre_id')->constrained('type_chambre')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplement_vue_chambre');
    }
}

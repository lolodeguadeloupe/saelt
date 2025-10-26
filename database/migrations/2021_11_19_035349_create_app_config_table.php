<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAppConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_config', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('nom');
            $table->string('adresse')->nullable();
            $table->string('site_web')->nullable();
            $table->string('telephone')->nullable();
            $table->longText('logo')->nullable();
            $table->foreignId('ville_id')->nullable();
            $table->timestamps();
        });
        DB::table('app_config')->insert([
            'nom' => 'Saelt voyages',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_config');
    }
}

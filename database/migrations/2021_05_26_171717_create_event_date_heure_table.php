<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventDateHeureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_date_heure', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->date('date');
            $table->time('time_start')->default('00:00:00');
            $table->time('time_end')->default('23:59:00');
            $table->string('model_event');
            $table->integer('status')->default(1);
            $table->string('ui_event');
            $table->string('color');
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
        Schema::dropIfExists('event_date_heure');
    }
}

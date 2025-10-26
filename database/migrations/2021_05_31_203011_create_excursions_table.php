<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcursionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('excursions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('duration');
            $table->string('heure_depart');
            $table->string('heure_arrive')->nullable();
            $table->string('availability')->nullable();
            $table->integer('participant_min')->default(1);
            $table->longText('fond_image')->nullable();
            $table->longText('card')->nullable();
            $table->integer('lunch')->default(0);
            $table->string('lunch_prestataire_id')->nullable(); 
            $table->integer('ticket')->default(0);
            $table->string('ticket_billeterie_id')->nullable();
            $table->string('status')->default(1);
            $table->text('description')->nullable();
            $table->string('adresse_arrive')->nullable();
            $table->string('adresse_depart')->nullable();
            $table->foreignId('ville_id')->nullable()->constrained('villes')->onDelete('cascade')->onUpdate('cascade');
             $table->foreignId('ile_id')->constrained('iles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('prestataire_id')->constrained('prestataire')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lieu_depart_id')->nullable()->constrained('service_port')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lieu_arrive_id')->nullable()->constrained('service_port')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('excursions');
    }

}

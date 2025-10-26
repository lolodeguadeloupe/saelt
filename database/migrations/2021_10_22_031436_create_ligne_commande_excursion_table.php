<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneCommandeExcursionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_commande_excursion', function (Blueprint $table) {
            $table->id();
            $table->string('excursion_id');
            $table->string('title');
            $table->integer('participant_min')->default(1);
            $table->string('duration')->nullable();
            $table->longText('fond_image')->nullable();
            $table->longText('card')->nullable();
            $table->integer('lunch')->default(0);
            $table->integer('ticket')->default(0);
            $table->string('adresse_arrive')->nullable();
            $table->string('adresse_depart')->nullable(); 
            $table->string('heure_depart');
            $table->string('heure_arrive')->nullable();
            $table->foreignId('ville_id')->constrained('villes')->onDelete('cascade')->onUpdate('cascade');
             $table->foreignId('ile_id')->constrained('iles')->onDelete('cascade')->onUpdate('cascade');
            $table->string('prestataire_id')->nullable();
            $table->string('lunch_prestataire_id')->nullable();
            $table->string('ticket_compagnie_id')->nullable();
            $table->foreignId('lieu_depart_id')->nullable()->constrained('service_port')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lieu_arrive_id')->nullable()->constrained('service_port')->onDelete('cascade')->onUpdate('cascade');
            /* */
            $table->date('date_excursion');
            $table->double('prix_unitaire')->default('0.0')->nullable();
            $table->double('prix_total')->default('0.0')->nullable();
            $table->foreignId('commande_id')->constrained('commande')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('ligne_commande_excursion');
    }
}

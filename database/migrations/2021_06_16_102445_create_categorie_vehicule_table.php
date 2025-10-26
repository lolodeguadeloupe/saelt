<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCategorieVehiculeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorie_vehicule', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->foreignId('famille_vehicule_id')->constrained('famille_vehicule')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
        DB::statement("INSERT INTO `categorie_vehicule` (`id`, `titre`, `description`, `famille_vehicule_id`, `created_at`, `updated_at`) VALUES
        (1, 'Categorie 1', NULL, 1, '2021-08-05 17:55:48', '2021-08-05 17:55:48'),
        (2, 'Categorie 3', NULL, 2, '2021-08-13 19:05:18', '2021-08-13 19:05:18'),
        (3, 'Categorie 21', NULL, 1, '2021-08-16 11:30:53', '2021-08-16 11:30:53');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_vehicule');
    }
}

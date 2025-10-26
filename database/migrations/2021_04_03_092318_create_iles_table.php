<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateIlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->longText('card')->nullable();
            $table->longText('background_image')->nullable();
            $table->foreignId('pays_id')->constrained('pays')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::statement("INSERT INTO `iles` (`id`, `name`, `card`, `background_image`, `pays_id`, `created_at`, `updated_at`) VALUES
        (1, 'Guadeloupe', 'assets/img/Guadeloupe_location_map-1-110x100.png', 'assets/img/Guadeloupe.jpg', 1, '2021-08-05 11:31:24', '2021-12-02 05:23:32'),
        (2, 'Marie-galante', 'assets/img/Marie_Galante_location_map-100x100.png', 'assets/img/Marie-Galante-1.jpg', 1, '2021-08-05 11:47:40', '2021-12-02 05:23:38'),
        (3, 'Les Saintes', NULL, NULL, 1, '2021-08-05 11:48:04', '2021-08-05 11:48:04'),
        (4, 'La Désirade', NULL, NULL, 1, '2021-08-05 11:48:40', '2021-08-05 11:48:40'),
        (5, 'Martinique', NULL, NULL, 1, '2021-08-05 11:49:05', '2021-08-05 11:49:05'),
        (6, 'Sainte-lucie', NULL, NULL, 1, '2021-08-05 11:49:23', '2021-08-05 11:49:23'),
        (7, 'La Dominique', NULL, NULL, 1, '2021-08-05 11:49:40', '2021-08-05 11:49:40'),
        (8, 'Saint-martin', NULL, NULL, 1, '2021-08-05 11:50:03', '2021-08-05 11:50:03'),
        (9, 'République Dominicaine', NULL, NULL, 1, '2021-08-05 11:50:17', '2021-08-05 11:50:17');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iles');
    }
}

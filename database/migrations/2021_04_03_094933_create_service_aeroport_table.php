<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateServiceAeroportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_aeroport', function (Blueprint $table) {
            $table->id();
            $table->string('code_service')->nullable();
            $table->string('name');
            $table->string('adresse')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->longText('logo')->nullable();
            $table->foreignId('ville_id')->constrained('villes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::statement("INSERT INTO `service_aeroport` (`id`, `code_service`, `name`, `adresse`, `phone`, `email`, `logo`, `ville_id`, `created_at`, `updated_at`) VALUES
        (1, '0001', 'Aeroport 1', 'Antananarivo', '0328565583', 'Administrator@brackets.sk', NULL, 1, '2021-08-05 12:09:45', '2021-08-05 12:09:45'),
        (2, '0002', 'Aeroport 2', 'Antananarivo', '0328565583', 'Administrator@brackets.sk', NULL, 1, '2021-08-05 12:10:04', '2021-08-05 12:10:04');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_aeroport');
    }
}

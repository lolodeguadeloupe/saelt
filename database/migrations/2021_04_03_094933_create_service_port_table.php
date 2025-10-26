<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateServicePortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_port', function (Blueprint $table) {
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

        DB::statement("INSERT INTO `service_port` (`id`, `code_service`, `name`, `adresse`, `phone`, `email`, `logo`, `ville_id`, `created_at`, `updated_at`) VALUES
        (1, '000', 'Port 1', 'Antananarivo', '0328565583', 'Administrator@brackets.sk', NULL, 1, '2021-08-05 12:15:41', '2021-08-05 12:15:41'),
        (2, '0002', 'Port 2', 'Antananarivo', '0328565583', 'Administrator@brackets.sk', NULL, 1, '2021-08-05 12:15:57', '2021-08-05 12:15:57'),
        (3, '0003', 'Port 3', 'Antananarivo', '0328565583', 'Randrianarisonravaka09@gmail.com', NULL, 1, '2021-08-10 13:29:43', '2021-08-10 13:29:43'),
        (8, NULL, 'Marie-Galante  grand-Bourg', NULL, NULL, NULL, NULL, 32, '2021-12-01 14:26:42', '2021-12-01 14:26:42'),
        (9, NULL, 'Guadeloupe pointe-À-Pitre', NULL, NULL, NULL, NULL, 22, '2021-12-01 14:27:30', '2021-12-01 14:27:30'),
        (10, NULL, 'Les saintes terre-De-Haut', NULL, NULL, NULL, NULL, 19, '2021-12-01 14:28:03', '2021-12-01 14:28:03'),
        (11, NULL, 'La Désirade Beauséjour', NULL, NULL, NULL, NULL, 29, '2021-12-01 15:02:12', '2021-12-01 15:02:12'),
        (12, NULL, 'Guadeloupe saint-François', NULL, NULL, NULL, NULL, 25, '2021-12-01 15:02:56', '2021-12-01 15:02:56'),
        (13, NULL, 'Marie-Galante  saint-Louis', NULL, NULL, NULL, NULL, 31, '2021-12-01 15:03:33', '2021-12-01 15:03:33'),
        (14, NULL, 'Guadeloupe trois-Rivières', NULL, NULL, NULL, NULL, 27, '2021-12-01 15:04:40', '2021-12-01 15:04:40');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_port');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code_postal')->nullable();
            $table->foreignId('pays_id')->constrained('pays')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::statement("INSERT INTO `villes` (`id`, `name`, `code_postal`, `pays_id`, `created_at`, `updated_at`) VALUES
        (1, 'Ville 1', '001', 1, '2021-08-05 08:29:10', '2021-12-21 05:41:40'),
        (18, 'Test 1', '101', 1, '2021-08-31 14:40:59', '2021-08-31 14:40:59'),
        (19, 'Terre de Haut', '97137', 3, '2021-09-09 19:15:49', '2021-09-09 19:15:49'),
        (20, 'Sainte-anne', '97180', 4, '2021-09-28 01:48:36', '2021-09-28 01:48:36'),
        (21, 'Basse-terre', '97410', 4, '2021-09-28 02:00:27', '2021-09-28 02:00:27'),
        (22, 'Pointe-à-pitre', '97110', 3, '2021-09-30 01:50:41', '2021-09-30 01:50:41'),
        (23, 'Ville 2', '102', 5, '2021-11-26 02:27:44', '2021-11-26 02:27:44'),
        (24, 'Sainte-Anne', '97180', 4, '2021-11-27 11:39:41', '2021-11-27 11:39:41'),
        (25, 'Saint-François', '97118', 4, '2021-11-29 09:38:06', '2021-11-29 09:38:06'),
        (26, 'Pointe-À-Pitre', '97110', 4, '2021-11-30 06:39:46', '2021-11-30 06:39:46'),
        (27, 'Trois-Rivières', '97114', 4, '2021-11-30 06:50:54', '2021-11-30 06:50:54'),
        (28, 'La Désirade', '97127', 9, '2021-11-30 06:58:38', '2021-11-30 06:58:38'),
        (29, 'Beauséjour', '97127', 9, '2021-11-30 06:59:43', '2021-11-30 06:59:43'),
        (30, 'Terre-De-Haut', '97137', 3, '2021-11-30 07:02:16', '2021-11-30 07:02:16'),
        (31, 'Saint-Louis', '97134', 12, '2021-11-30 07:04:10', '2021-11-30 07:04:10'),
        (32, 'Grand-Bourg', '97112', 12, '2021-12-01 11:26:39', '2021-12-01 11:26:39'),
        (33, 'Deshaies', NULL, 4, '2022-01-06 13:01:03', '2022-01-06 13:01:03'),
        (34, 'Le Gosier', NULL, 4, '2022-01-06 13:23:37', '2022-01-06 13:23:37'),
        (35, 'Saint-Médard-en-Jalles', '33160', 13, '2022-01-08 14:30:31', '2022-01-08 14:30:31');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('villes');
    }
}

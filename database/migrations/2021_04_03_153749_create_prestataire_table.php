<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePrestataireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestataire', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('adresse');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('second_email')->nullable();
            $table->string('heure_ouverture')->default("00:00")->nullable();
            $table->string('heure_fermeture')->default("00:00")->nullable();
            $table->longText('logo')->nullable();
            $table->foreignId('ville_id')->constrained('villes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::statement("INSERT INTO `prestataire` (`id`, `name`, `adresse`, `phone`, `email`, `heure_ouverture`, `heure_fermeture`, `logo`, `ville_id`, `created_at`, `updated_at`) VALUES
        (1, 'Prestataire 1', 'Antananarivo', '0328565583', 'administrator@brackets.sk', NULL, NULL, 'assets/img/prestataire/OKRKmg9OKUsxHidP31lwWhz69.png', 1, '2021-08-05 11:29:16', '2021-11-26 05:23:30'),
        (11, 'Test', 'Antananarivo', '0328565583', 'administrator@brackets.sk', NULL, NULL, 'assets/img/prestataire/Y8ZLJ9Z6kTc7f9YTPbHgCGIdS.png', 18, '2021-08-31 19:32:34', '2021-12-02 06:02:22'),
        (12, 'Le Bois Joli', 'Route du Bois Joli', '0590995038', 'contact@leboisjoli.fr', NULL, NULL, NULL, 19, '2021-09-09 22:15:57', '2021-09-09 22:15:57'),
        (16, 'Le Bois Joli 3e', 'Route Du Bois Joli', '0590995038', 'contact@boisjoli.fr', NULL, NULL, 'assets/img/prestataire/CJiNOF20nfgVggsLwOyvIG5H9.jpeg', 19, '2021-09-15 12:05:04', '2021-12-02 06:02:59'),
        (17, 'Rotaloca', 'Ld Durivage 97180', '0590242019', 'contact.rotaloca@orange.fr', NULL, NULL, NULL, 20, '2021-09-28 04:48:54', '2021-09-28 04:48:54'),
        (18, 'Test Manitra', 'Antananarivo', NULL, NULL, NULL, NULL, 'assets/img/prestataire/99LNFaaCjTEiAj3H4cHIJriCn.png', 23, '2021-11-26 05:27:53', '2021-11-26 05:27:53'),
        (19, 'Test Part', 'Antananarivo', NULL, NULL, NULL, NULL, NULL, 23, '2021-11-26 05:48:26', '2021-11-26 05:48:26'),
        (20, 'Saelt Voyages', 'Bd Hibéné', '0590881980', 'saelt@orange.fr', NULL, NULL, NULL, 24, '2021-11-27 14:39:49', '2021-12-02 06:04:50'),
        (21, 'Bwa Chik Hôtel & Golf 3*', 'Avenue De L\'europe', '0590000000', 'reservation@bwachik.com', NULL, NULL, NULL, 25, '2021-11-29 12:38:27', '2021-11-29 12:38:27');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestataire');
    }
}

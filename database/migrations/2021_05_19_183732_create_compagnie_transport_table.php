<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompagnieTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compagnie_transport', function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->string("adresse");
            $table->longText('logo')->nullable();
            $table->string('type_transport');
            $table->string('heure_ouverture')->default("00:00")->nullable();
            $table->string('heure_fermeture')->default("00:00")->nullable();
            $table->foreignId('ville_id')->constrained('villes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::statement("INSERT INTO `compagnie_transport` (`id`, `nom`, `email`, `phone`, `adresse`, `logo`, `type_transport`, `heure_ouverture`, `heure_fermeture`, `ville_id`, `created_at`, `updated_at`) VALUES
        (1, 'Compagnie 1', 'administrator@brackets.sk', '0328565583', 'Antananarivo', NULL, 'Aérien', NULL, NULL, 1, '2021-08-05 12:11:04', '2021-12-02 11:30:24'),
        (6, 'Compagnie 1', 'administrator@brackets.sk', '0328565583', 'Antananarivo', NULL, 'Maritime', NULL, NULL, 1, '2021-08-05 12:23:04', '2021-12-02 11:30:34'),
        (7, 'Compagnie 2', 'administrator@brackets.sk', '0328565583', 'Antananarivo', NULL, 'Maritime', NULL, NULL, 1, '2021-08-05 12:23:28', '2021-12-02 11:30:43'),
        (8, 'Compagnie 3', 'administrator@brackets.sk', '0328565583', 'Antananarivo', 'assets/img/compagnie-transport/vhIYlFQDSlvdaEaYUMK37qB8y.jpeg', 'Maritime', NULL, NULL, 1, '2021-08-09 14:43:14', '2021-12-02 11:30:54'),
        (9, 'Compagnie 4', 'administrator@brackets.sk', '0328565583', 'Antananarivo', 'assets/img/compagnie-transport/kYYuDZf30ZRFHCB7yklMU1csV.jpeg', 'Maritime', NULL, NULL, 1, '2021-08-09 14:43:36', '2021-12-02 11:31:06'),
        (10, 'Compagnie 5', 'administrator@brackets.sk', '0328565583', 'Antananarivo', 'assets/img/compagnie-transport/QuVa5YFz9BfxcalDLaKhJEjwn.jpeg', 'Maritime', NULL, NULL, 1, '2021-08-09 14:43:57', '2021-12-02 11:31:16'),
        (11, 'Express Des Iles', 'smoysan@jeansforfreedom.com', '0825359000', 'Gare Maritime De Bergevin', 'assets/img/compagnie-transport/9FKt0fWXpyAf5iC5wFbusMgje.jpeg', 'Maritime', NULL, NULL, 26, '2021-11-30 09:44:55', '2021-12-02 11:32:11'),
        (12, 'Val Ferry', 'val-ferry@orange.fr', '0590574574', 'Gare Maritime De Bergevin', 'assets/img/compagnie-transport/yXNJMkgZMYNwVcYX6zefMC5hO.png', 'Maritime', NULL, NULL, 26, '2021-11-30 09:46:51', '2021-12-02 11:32:27'),
        (13, 'Comadile', 'contact@comadile.fr', '0690494933', 'Port De Pêche', 'assets/img/compagnie-transport/k4P2Peq4qm4qRO6gbqpFduN8o.png', 'Maritime', NULL, NULL, 25, '2021-11-30 09:48:42', '2021-12-02 08:23:22'),
        (14, 'Ctm Deher', 'reservation@ctmdeher.com', '0590920639', 'Chemin Départemental N° 7 Dit Bord De Mer', 'assets/img/compagnie-transport/fsPMmDZTe3HpSUq0AaxEJQPKw.jpeg', 'Maritime', NULL, NULL, 27, '2021-11-30 09:51:15', '2021-12-02 11:32:50');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compagnie_transport');
    }
}

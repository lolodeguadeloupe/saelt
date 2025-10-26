<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateModePayementConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mode_payement_config', function (Blueprint $table) {
            $table->id();
            $table->text('key_test')->nullable();
            $table->text('key_prod')->nullable();
            $table->string('base_url_test');
            $table->string('base_url_prod');
            $table->string('api_version')->nullable();
            $table->integer('mode')->default(0); /* mode test */
            $table->foreignId('mode_payement_id')->constrained('mode_payement')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::statement("INSERT INTO `mode_payement_config` (`id`, `key_test`, `key_prod`, `base_url_test`, `base_url_prod`, `api_version`, `mode`, `mode_payement_id`, `created_at`, `updated_at`) VALUES
        (1, 'sk_test_6VYVsI8iPYCe2IYgA0IE6i7c', 'sk_live_2oiUvSnR1ssAI6OyWUi6Ww5m', 'Https://api.sandbox.getalma.eu', 'Https://api.getalma.eu', 'v1', 0, 7, '2021-11-24 09:26:05', '2021-11-26 11:20:57');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mode_payement_config');
    }
}

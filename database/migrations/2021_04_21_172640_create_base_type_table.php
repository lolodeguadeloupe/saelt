<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBaseTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_type', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->unique();
            $table->integer('nombre')->default(0);
            $table->text('description')->nullable();
            $table->integer('reference_prix')->default(0)->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO `base_type` (`id`, `titre`, `nombre`, `description`,`reference_prix`, `created_at`, `updated_at`) VALUES
        (1, 'Base double', 2, NULL,1 ,'2021-12-02 04:55:32', '2021-12-02 04:55:32'),
        (2, 'Base triple', 3, NULL,0, '2021-12-02 04:57:05', '2021-12-02 04:57:05'),
        (4, 'Single', 1, NULL,0, '2022-01-03 09:22:02', '2022-01-03 09:22:02'),
        (5, 'Quadruple', 4, NULL,0, '2022-01-03 09:28:12', '2022-01-03 09:28:12');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_type');
    }
}

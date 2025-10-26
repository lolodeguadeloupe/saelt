<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTypePersonneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_personne', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->string('age');
            $table->text("description")->nullable();
            $table->string('model')->nullable();
            $table->integer('model_id')->nullable();
            $table->integer('reference_prix')->default(0)->nullable();
            $table->integer('original_id')->nullable();
            $table->timestamps();
        });

        $type = [];
        $type[] = [
            'id' => 1,
            'type' => 'Adulte',
            'age' => '+18 ans',
            'reference_prix' => 1,
        ];
        $type[] = [
            'id' => 2,
            'type' => 'Enfant',
            'age' => '-18 ans',
            'reference_prix' => 0,
        ];
        $type[] = [
            'id' => 3,
            'type' => 'Bébé',
            'age' => '-10 ans',
            'reference_prix' => 0,
        ];

        foreach ($type as $value) {
            DB::table('type_personne')->insert($value);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_personne');
    }
}

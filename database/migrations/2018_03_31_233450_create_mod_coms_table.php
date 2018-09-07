<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModComsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cda_modcom', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('ModComId');
            $table->string('ModComSg', 10)->default(null);
            $table->string('ModComNm', 60)->default(null);
            $table->bigInteger('TpModId')->default(null);
            $table->bigInteger('CanalId')->default(null);
            $table->bigInteger('ModComAnxId')->default(null);
            $table->mediumText('ModTexto');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cda_modcom');
    }
}

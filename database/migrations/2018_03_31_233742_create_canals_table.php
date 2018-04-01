<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cda_canal', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('CANALID');
            $table->string('CANALSG', 10);
            $table->string('CANALNM', 60);

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
        Schema::drop('cda_canal');
    }
}

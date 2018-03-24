<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdaTabsys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cda_tabsys', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('TABSYSID');
            $table->string('TABSYSSG', 10);
            $table->string('TABSYSNM', 60);
            $table->boolean('TABSYSSQL')->default(0);

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
        Schema::dropIfExists('cda_tabsys');
    }
}

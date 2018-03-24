<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegTabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cda_regtab', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('REGTABID');
            $table->string('REGTABSG', 10);
            $table->string('REGTABNM', 60)->default(null);
            $table->longText('REGTABSQL');
            $table->bigInteger('TABSYSID');
            $table->string('REGTABIMP', 255)->default(null);

            $table->index('tabsysid','cda_regtab_fk_cda_tab_042413d3');

            $table->foreign('tabsysid')
                ->references('tabsysid')->on('s');

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
        Schema::dropIfExists('cda_regtab');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAntminersTableAddLimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ant_miners',function(Blueprint $table){
        	$table->integer('temp_limit')->unsigned()->nullable()->after('log');
        	$table->integer('hr_limit')->unsigned()->nullable()->after('temp_limit');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('ant_miners',function(Blueprint $table){
		    $table->dropColumn('temp_limit');
		    $table->dropColumn('hr_limit');
	    });
    }
}

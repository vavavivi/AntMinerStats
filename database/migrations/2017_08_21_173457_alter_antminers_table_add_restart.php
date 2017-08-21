<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAntminersTableAddRestart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ant_miners', function(Blueprint $table){
        	$table->boolean('restart')->default(0)->after('log');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('ant_miners', function(Blueprint $table){
		    $table->dropColumn('restart');
	    });
    }
}

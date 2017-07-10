<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAntMinersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('ant_miners', function (Blueprint $table) {
	    	$table->dropColumn('username');
	    	$table->dropColumn('password');
	    	$table->integer('user_id')->unsigned()->after('id');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('ant_miners', function (Blueprint $table) {
		    $table->dropColumn('user_id');
		    $table->string('username')->after('port');
		    $table->string('password')->after('username');;
	    });
    }
}

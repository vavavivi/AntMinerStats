<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAntMinersTableAddLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('ant_miners', function (Blueprint $table) {
		    $table->integer('location_id')->unsigned()->nullable()->after('user_id');

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
		    $table->dropColumn('location_id');

	    });
    }
}

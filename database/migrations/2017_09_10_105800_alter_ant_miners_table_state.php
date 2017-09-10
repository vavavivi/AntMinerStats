<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAntMinersTableState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('ant_miners', function (Blueprint $table) {
		    $table->boolean('active')->default(1)->after('id');
		    $table->string('d_reason')->nullable()->after('active');
		    $table->tinyInteger('f_count')->unsigned()->default(0)->after('url');
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
		    $table->dropColumn('active');
		    $table->dropColumn('d_reason');
		    $table->dropColumn('f_count');
	    });
    }
}

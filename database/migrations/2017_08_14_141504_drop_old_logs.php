<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropOldLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::dropIfExists('antlogs');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::create('antlogs', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('ant_miner_id')->unsigned();
		    $table->text('data')->nullable();
		    $table->timestamps();
	    });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlertsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->increments('id');

	        $table->integer('user_id')->unsigned();
	        $table->foreign('user_id')
		        ->references('id')
		        ->on('users')
		        ->onUpdate('cascade')
		        ->onDelete('cascade');
	        ;

	        $table->integer('ant_miner_id')->unsigned();
	        $table->foreign('ant_miner_id')
		        ->references('id')
		        ->on('ant_miners')
		        ->onUpdate('cascade')
		        ->onDelete('cascade');
	        ;

	        $table->string('status');


	        $table->string('subject');
	        $table->text('body');

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
        Schema::drop('alerts');
    }
}

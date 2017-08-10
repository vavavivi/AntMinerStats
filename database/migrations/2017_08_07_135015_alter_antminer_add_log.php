<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAntminerAddLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ant_miners', function (Blueprint $table) {
            $table->boolean('log')->after('options')->default(0);
            $table->string('url')->after('log')->nullable();
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
            $table->dropColumn('log');
        });
    }
}

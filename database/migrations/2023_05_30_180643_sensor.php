<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_sensor', function (Blueprint $table) {
            $table->increments('sensor_id');
            $table->float('voltage');
            $table->float('current');
            $table->float('power');
            $table->float('energy');
            $table->float('frequency');
            $table->float('powerfactor');
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
        Schema::dropIfExists('tb_sensor');
    }
};

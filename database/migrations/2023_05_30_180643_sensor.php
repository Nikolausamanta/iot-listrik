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
            $table->string('mac_address');
            $table->float('voltage')->default('0');
            $table->float('current')->default('0');
            $table->float('power')->default('0');
            $table->float('energy')->default('0');
            $table->float('frequency')->default('0');
            $table->float('powerfactor')->default('0');
            $table->float('kwh')->nullable();
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

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


        Schema::table('tb_relay', function (Blueprint $table) {
            $table->integer('device_id')->length(10)->unsigned()->after('relay_id')->default('0');
            $table->foreign('device_id')->references('device_id')->on('tb_device');
        });

        Schema::table('tb_schedule', function (Blueprint $table) {
            $table->integer('device_id')->length(10)->unsigned()->after('schedule_id')->default('0');
            $table->foreign('device_id')->references('device_id')->on('tb_device');
        });


        // Schema::table('tb_sensor', function (Blueprint $table) {
        //     $table->integer('device_id')->length(10)->unsigned()->after('sensor_id')->default('0');
        //     $table->foreign('device_id')->references('device_id')->on('tb_device');
        // });

        Schema::table('tb_timer', function (Blueprint $table) {
            $table->integer('device_id')->length(10)->unsigned()->after('timer_id')->default('0');
            $table->foreign('device_id')->references('device_id')->on('tb_device');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_relay', function (Blueprint $table) {
            $table->dropForeign(['device_id']);
        });

        Schema::table('tb_schedule', function (Blueprint $table) {
            $table->dropForeign(['device_id']);
        });

        // Schema::table('tb_sensor', function (Blueprint $table) {
        //     $table->dropForeign(['device_id']);
        // });

        Schema::table('tb_timer', function (Blueprint $table) {
            $table->dropForeign(['device_id']);
        });
    }
};

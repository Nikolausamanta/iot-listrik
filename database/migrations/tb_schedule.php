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
        Schema::create('tb_schedule', function (Blueprint $table) {
            $table->increments('schedule_id');
            $table->string('schedule_group', 10);
            $table->string('nama_schedule', 250);
            $table->string('time');
            $table->boolean('status')->default('0');
            $table->string('schedule_condition', 10);
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
        Schema::dropIfExists('tb_schedule');
    }
};

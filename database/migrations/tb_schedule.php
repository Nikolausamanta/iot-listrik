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
            $table->string('nama_schedule', 250);
            $table->string('waktu1');
            $table->string('waktu2');
            $table->string('tanggal1');
            $table->string('status')->default('0');
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

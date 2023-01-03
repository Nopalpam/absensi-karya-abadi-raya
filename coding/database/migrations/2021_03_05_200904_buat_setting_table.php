<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_perusahaan');
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->integer('radius_area')->nullable();
            $table->string('path_logo')->nullable();
            $table->text('map_api_key')->nullable();
            $table->time('jam_masuk_kerja')->nullable();
            $table->time('jam_pulang_kerja')->nullable();
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
        Schema::dropIfExists('setting');
    }
}

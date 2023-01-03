<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_karyawan');
            $table->date('tanggal');
            $table->datetime('waktu_check')->nullable();
            $table->boolean('hadir')->default(false);
            $table->boolean('telat')->default(false);
            $table->boolean('ijin')->default(false);
            $table->boolean('sakit')->default(false);
            $table->boolean('cuti')->default(false);
            $table->boolean('check_in')->default(false);
            $table->boolean('check_out')->default(false);
            $table->boolean('visit')->default(false);
            $table->string('lang_code')->nullable();
            $table->string('lat_code')->nullable();
            $table->text('gambar')->nullable();
            $table->enum('status_absen', ['online', 'offline', 'ijin', 'sakit', 'cuti'])->default('offline');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('absensi');
    }
}

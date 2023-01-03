<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSikKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sik_karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_karyawan');
            $table->date('tanggal_start');
            $table->date('tanggal_end');
            $table->enum('sik', ['ijin', 'cuti', 'sakit']);
            $table->boolean('verified')->default(false);
            $table->string('verified_by')->nullable();
            $table->text('gambar')->nullable();
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
        Schema::dropIfExists('sik_karyawan');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id' => 1,
            'nama_perusahaan' => 'PT. Coba',
            'alamat' => 'Jl. Raya Senen',
            'telepon' => '081234779987',
            'path_logo' => '/img/logo.svg',
            'radius_area' => 500
        ]);
    }
}

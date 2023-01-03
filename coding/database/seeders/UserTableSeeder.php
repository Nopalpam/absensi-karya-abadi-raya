<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'foto' => '/img/user.jpg',
                'level' => 'admin'
            ],
            [
                'name' => 'Karyawan 01',
                'email' => 'karyawan@gmail.com',
                'password' => bcrypt('karyawan'),
                'foto' => '/img/user.jpg',
                'level' => 'karyawan',
                'nip' => 'KRY01',
            ]
        );

        array_map(function (array $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }, $users);
    }
}

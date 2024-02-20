<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_role')->upsert([
            [
                'kd_role' => 99,
                'ur_role' => 'superuser',
            ],
            [
                'kd_role' => 1,
                'ur_role' => 'Administrator',
            ],
            [
                'kd_role' => 2,
                'ur_role' => 'admin',
            ],
            [
                'kd_role' => 3,
                'ur_role' => 'Sales',
            ],
        ], ['kd_role']);

        DB::table('d_karyawan')->upsert([
            [
                'nik'       => 2134,
                'nama'      => 'Superuser',
                'satker'    => '',
                'alamat'    => 'alamat User',
                'jk'        => 'L',
                'ktp'       => '00',
                'no_hp'     => '00',
                'reference' => '',
            ],
            [
                'nik'       => '2135',
                'nama'      => 'margana',
                'satker'    => 'ramwater',
                'alamat'    => 'alamat Administrator',
                'jk'        => 'L',
                'ktp'       => '00',
                'no_hp'     => '00',
                'reference' => '',
            ],
            [
                'nik'       => '2136',
                'nama'      => 'Rista',
                'satker'    => 'ramwater',
                'alamat'    => 'alamat Admin',
                'jk'        => 'P',
                'ktp'       => '00',
                'no_hp'     => '00',
                'reference' => '',
            ],
            [
                'nik'       => '2137',
                'nama'      => 'Nama Sales 1',
                'satker'    => 'ramwater',
                'alamat'    => 'alamat Sales',
                'jk'        => 'L',
                'ktp'       => '00',
                'no_hp'     => '00',
                'reference' => '',
            ],
            [
                'nik'       => '2138',
                'nama'      => 'Nama Sales 2',
                'satker'    => 'ramwater',
                'alamat'    => 'alamat Sales',
                'jk'        => 'L',
                'ktp'       => '00',
                'no_hp'     => '00',
                'reference' => '',
            ],
            [
                'nik'       => '2139',
                'nama'      => 'Nama Sales 3',
                'satker'    => 'ramwater',
                'alamat'    => 'alamat Sales',
                'jk'        => 'L',
                'ktp'       => '00',
                'no_hp'     => '00',
                'reference' => '',
            ],
            [
                'nik'       => '2140',
                'nama'      => 'ramwater',
                'satker'    => 'ramwater',
                'alamat'    => 'alamat Sales',
                'jk'        => 'L',
                'ktp'       => '00',
                'no_hp'     => '00',
                'reference' => '',
            ],
        ], ['nik']);

        DB::table('users')->upsert([
            [
                'name'     => 'Superuser',
                'nik'      => 2134,
                'username' => 'superuser',
                'phone'    => '098765544323',
                'pwd'      => '09120912',
                'kd_role'  => 99,
                'active'   => '1',
                'email'    => 'mail1@mail.com',
                'password' => Hash::make('09120912'),
            ],
            [
                'name'     => 'Administrator',
                'nik'      => 2135,
                'username' => 'administrator',
                'phone'    => '098765544323',
                'pwd'      => '09120912',
                'kd_role'  => 1,
                'active'   => '1',
                'email'    => 'mail2@mail.com',
                'password' => Hash::make('09120912'),
            ],
            [
                'name'     => 'Rista',
                'nik'      => 2136,
                'username' => 'rista',
                'phone'    => '098765544323',
                'pwd'      => '09120912',
                'kd_role'  => 2,
                'active'   => '1',
                'email'    => 'mail3@mail.com',
                'password' => Hash::make('09120912'),
            ],
            [
                'name'     => 'Nama Sales 1',
                'nik'      => 2137,
                'username' => 'sales1',
                'phone'    => '098765544323',
                'pwd'      => '09120912',
                'kd_role'  => 3,
                'active'   => '1',
                'email'    => 'mail4@mail.com',
                'password' => Hash::make('09120912'),
            ],
            [
                'name'     => 'Nama Sales 2',
                'nik'      => 2138,
                'username' => 'sales2',
                'phone'    => '098765544323',
                'pwd'      => '09120912',
                'kd_role'  => 3,
                'active'   => '1',
                'email'    => 'mail5@mail.com',
                'password' => Hash::make('09120912'),
            ],
            [
                'name'     => 'Nama Sales 3',
                'nik'      => 2139,
                'username' => 'sales3',
                'phone'    => '098765544323',
                'pwd'      => '09120912',
                'kd_role'  => 3,
                'active'   => '1',
                'email'    => 'mail6@mail.com',
                'password' => Hash::make('09120912'),
            ],
            [
                'name'     => 'ramwater',
                'nik'      => 2140,
                'username' => 'sales3',
                'phone'    => '098765544323',
                'pwd'      => '09120912',
                'kd_role'  => 3,
                'active'   => '1',
                'email'    => 'mail7@mail.com',
                'password' => Hash::make('09120912'),
            ],
        ], ['username']);
    }
}

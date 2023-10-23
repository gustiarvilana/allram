<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_menu')->upsert([
            [
                'kd_menu'       => 1,
                'kd_parent'     => 0,
                'type'          => '',
                'ur_menu_title' => 'Security',
                'ur_menu_desc'  => 'Menu1',
                'link_menu'     => '/security',
                'bg_color'      => '#',
                'icon'          => 'ri-secure-payment-line',
                'order'         => '1',
                'is_active'     => '1',
            ],
            [
                'kd_menu'       => 2,
                'kd_parent'     => 0,
                'type'          => '',
                'ur_menu_title' => 'Lorem Ipsum2',
                'ur_menu_desc'  => 'Menu2',
                'link_menu'     => '#',
                'bg_color'      => '#',
                'icon'          => 'ri-bar-chart-box-line',
                'order'         => '2',
                'is_active'     => '1',
            ],
            [
                'kd_menu'       => 3,
                'kd_parent'     => 4,
                'type'          => '',
                'ur_menu_title' => 'Datang Barang',
                'ur_menu_desc'  => 'Datang Barang',
                'link_menu'     => '/ramwater/datangbarang',
                'bg_color'      => '#',
                'icon'          => 'fas fa-truck-loading',
                'order'         => '3',
                'is_active'     => '1',
            ],

            [
                'kd_menu'       => 4,
                'kd_parent'     => 0,
                'type'          => '',
                'ur_menu_title' => 'RAM Water',
                'ur_menu_desc'  => 'RAM Water',
                'link_menu'     => '/ramwater',
                'bg_color'      => '#',
                'icon'          => 'ri-calendar-todo-line',
                'order'         => '5',
                'is_active'     => '1',
            ],
            [
                'kd_menu'       => 5,
                'kd_parent'     => 0,
                'type'          => 'nav',
                'ur_menu_title' => 'RAM Armalia',
                'ur_menu_desc'  => 'RAM Armalia',
                'link_menu'     => '#',
                'bg_color'      => '#',
                'icon'          => 'ri-calendar-todo-line',
                'order'         => '4',
                'is_active'     => '1',
            ],
            [
                'kd_menu'       => 6,
                'kd_parent'     => 1,
                'type'          => '',
                'ur_menu_title' => 'User Menu',
                'ur_menu_desc'  => '/roleole',
                'link_menu'     => '/security/user_menu',
                'bg_color'      => '#',
                'icon'          => 'fab fa-mendeley',
                'order'         => '6',
                'is_active'     => '1',
            ],
            [
                'kd_menu'       => 7,
                'kd_parent'     => 1,
                'type'          => '',
                'ur_menu_title' => 'User Role Menu',
                'ur_menu_desc'  => 'User Role Menu',
                'link_menu'     => '/security/user_role',
                'bg_color'      => '#',
                'icon'          => 'fas fa-user-tag',
                'order'         => '7',
                'is_active'     => '1',
            ],
            [
                'kd_menu'       => 8,
                'kd_parent'     => 1,
                'type'          => '',
                'ur_menu_title' => 'Karyawan',
                'ur_menu_desc'  => 'karyawan',
                'link_menu'     => '/security/karyawan',
                'bg_color'      => '#',
                'icon'          => 'fas fa-users',
                'order'         => '7',
                'is_active'     => '1',
            ],
        ], ['kd_menu', 'kd_parent']);

        DB::table('users_role_menu')->upsert([
            [
                'kd_role' => 1,
                'kd_menu' => 1,
                'tahun' => 2023
            ],
            [
                'kd_role' => 1,
                'kd_menu' => 2,
                'tahun' => 2023
            ],
            [
                'kd_role' => 1,
                'kd_menu' => 3,
                'tahun' => 2023
            ],
            [
                'kd_role' => 1,
                'kd_menu' => 4,
                'tahun' => 2023
            ],
            [
                'kd_role' => 1,
                'kd_menu' => 5,
                'tahun' => 2023
            ],
            [
                'kd_role' => 1,
                'kd_menu' => 6,
                'tahun' => 2023
            ],
            [
                'kd_role' => 1,
                'kd_menu' => 7,
                'tahun' => 2023
            ],
            [
                'kd_role' => 1,
                'kd_menu' => 8,
                'tahun' => 2023
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 1,
                'tahun' => 2023
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 2,
                'tahun' => 2023
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 3,
                'tahun'   => 2023
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 4,
                'tahun' => 2023
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 5,
                'tahun' => 2023
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 6,
                'tahun' => 2023
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 7,
                'tahun' => 2023
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 8,
                'tahun' => 2023
            ],
            [
                'kd_role' => 2,
                'kd_menu' => 3,
                'tahun' => 2023
            ],
            [
                'kd_role' => 3,
                'kd_menu' => 2,
                'tahun' => 2023
            ], [
                'kd_role' => 2,
                'kd_menu' => 4,
                'tahun' => 2023
            ],
        ], ['kd_role', 'kd_menu']);
    }
}

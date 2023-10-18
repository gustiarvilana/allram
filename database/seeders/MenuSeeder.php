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
                'ur_menu_title' => 'Lorem Ipsum1',
                'ur_menu_desc'  => 'Menu1',
                'link_menu'     => '#',
                'bg_color'      => '#',
                'icon'          => 'ri-store-line',
                'order'         => '1',
                'is_active'     => '1',
            ],
            [
                'kd_menu'       => 2,
                'kd_parent'     => 0,
                'ur_menu_title' => 'Lorem Ipsum2',
                'ur_menu_desc'  => 'Menu2',
                'link_menu'     => '#',
                'bg_color'      => '#',
                'icon'          => 'ri-bar-chart-box-line',
                'order'         => '1',
                'is_active'     => '1',
            ],
            [
                'kd_menu'       => 3,
                'kd_parent'     => 0,
                'ur_menu_title' => 'Lorem Ipsum3',
                'ur_menu_desc'  => 'Menu3',
                'link_menu'     => '#',
                'bg_color'      => '#',
                'icon'          => 'ri-calendar-todo-line',
                'order'         => '1',
                'is_active'     => '1',
            ],
        ], ['kd_menu', 'kd_parent']);

        DB::table('users_role_menu')->upsert([
            [
                'kd_role' => 1,
                'kd_menu' => 1,
            ],
            [
                'kd_role' => 1,
                'kd_menu' => 2,
            ],
            [
                'kd_role' => 1,
                'kd_menu' => 3,
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 1,
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 2,
            ],
            [
                'kd_role' => 99,
                'kd_menu' => 3,
            ],
            [
                'kd_role' => 2,
                'kd_menu' => 2,
            ],
            [
                'kd_role' => 3,
                'kd_menu' => 3,
            ],
        ], ['kd_role', 'kd_menu']);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("INSERT IGNORE INTO `users_menu`
            (`id`, `kd_menu`, `kd_parent`, `type`, `ur_menu_title`, `ur_menu_desc`, `link_menu`, `bg_color`, `icon`, `order`, `is_active`)
            VALUES
            (8, 3, 4, null, 'Pembelian', 'Ramwater Pembelian', '/ramwater/pembelian', '#', 'ri-calendar-todo-line', 1, 1)
        ");

        DB::statement("INSERT IGNORE INTO `users_role_menu`
            (`id`, `kd_role`, `kd_menu`, `tahun`)
            VALUES
            (15, '99', '3', '2024'),
            (16, '1', '3', '2024')
        ");
    }
}

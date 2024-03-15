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
            (8, 3, 4, null, 'Pembelian', 'Ramwater Pembelian', '#', '#', 'fas fa-truck', 1, 1),
            (9, 9, 3, null, 'Input Pembelian', 'Ramwater Pembelian', '/ramwater/pembelian', '#', 'ri-calendar-todo-line', 1, 1),
            (10, 10, 3, null, 'Laporan Pembelian', 'Ramwater Pembelian', '/ramwater/pembelian/laporan', '#', 'ri-calendar-todo-line', 2, 1),
            (11, 11, 3, null, 'Pembayaran', 'Ramwater Pembayaran', '/ramwater/pembelian/pembayaran', '#', 'ri-calendar-todo-line', 3, 1),

            (12, 12, 4, null, 'Penjualan', 'Ramwater penjualan', '#', '#', 'fas fa-cart-plus', 3, 1),
            (13, 13, 12, null, 'Input', 'Ramwater Input penjualan', '/ramwater/penjualan', '#', 'fas fa-cart-plus', 1, 1),
            (14, 14, 12, null, 'Laporan', 'Ramwater Laporan penjualan', '/ramwater/penjualan/laporan', '#', 'ri-calendar-todo-line', 2, 1),
            (15, 15, 12, null, 'Pembayaran', 'Ramwater Pembayaran penjualan', '/ramwater/penjualan/pembayaran', '#', 'ri-calendar-todo-line', 3, 1)
        ");


        DB::statement("INSERT IGNORE INTO `users_role_menu`
            (`id`, `kd_role`, `kd_menu`, `tahun`)
            VALUES
            (15, '99', '3', '2024'),
            (16, '1', '3', '2024'),
            (17, '99', '9', '2024'),
            (18, '1', '9', '2024'),
            (19, '99', '10', '2024'),
            (20, '1', '10', '2024'),
            (21, '99', '11', '2024'),
            (22, '1', '11', '2024'),
            (23, '99', '12', '2024'),
            (24, '1', '12', '2024'),
            (25, '99', '13', '2024'),
            (26, '1', '13', '2024'),
            (27, '99', '14', '2024'),
            (28, '1', '14', '2024'),
            (29, '99', '15', '2024'),
            (30, '1', '15', '2024')
        ");
    }
}

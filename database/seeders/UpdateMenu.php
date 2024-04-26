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
            (10, 10, 3, null, 'Detail Pembelian', 'Ramwater Pembelian', '/ramwater/pembelian/detail', '#', 'ri-calendar-todo-line', 2, 1),
            (11, 11, 3, null, 'Pembayaran', 'Ramwater Pembayaran', '/ramwater/pembelian/pembayaran', '#', 'ri-calendar-todo-line', 3, 1),

            (12, 12, 4, null, 'Penjualan', 'Ramwater penjualan', '#', '#', 'fas fa-cart-plus', 2, 1),
            (13, 13, 12, null, 'Input', 'Ramwater Input penjualan', '/ramwater/penjualan', '#', 'fas fa-cart-plus', 1, 1),
            (14, 14, 12, null, 'Detail Penjualan', 'Ramwater Laporan penjualan', '/ramwater/penjualan/detail', '#', 'ri-calendar-todo-line', 2, 1),
            (15, 15, 12, null, 'Pembayaran', 'Ramwater Pembayaran penjualan', '/ramwater/penjualan/pembayaran', '#', 'ri-calendar-todo-line', 3, 1),
            (16, 16, 4, null, 'OPS', 'Ramwater OPS', '#', '#', 'fa-solid fa-cart-flatbed-suitcase', 3, 1),
            (17, 17, 16, null, 'Input OPS', 'Ramwater Input ops', '/ramwater/ops', '#', 'fa-solid fa-cart-flatbed-suitcase', 1, 1),
            (18, 18, 12, null, 'Penyerahan', 'Ramwater Penyerahan', '/ramwater/penjualan/penyerahan', '#', 'fa-solid fa-cart-flatbed-suitcase', 4, 1),
            (19, 19, 4, null, 'Laporan', 'Ramwater Laporan', '#', '#', 'fa-solid fa-cart-flatbed-suitcase', 4, 1),
            (20, 20, 19, null, 'Laporan Pembelian', 'Ramwater Laporan Pembelian', '/ramwater/laporan/pembelian', '#', 'fa-solid fa-cart-flatbed-suitcase', 1, 1),
            (21, 21, 19, null, 'Laporan Penjualan', 'Ramwater Laporan penjualan', '/ramwater/laporan/penjualan', '#', 'fa-solid fa-cart-flatbed-suitcase', 2, 1),
            (22, 22, 19, null, 'Laporan OPS', 'Ramwater Laporan ops', '/ramwater/laporan/ops', '#', 'fa-solid fa-cart-flatbed-suitcase', 3, 1),
            (23, 23, 19, null, 'Hutang Nominal', 'Ramwater Hutang Nominal', '/ramwater/hutang/nominal', '#', 'fa-solid fa-cart-flatbed-suitcase',1, 1),
            (24, 24, 19, null, 'Piutang Nominal', 'Ramwater Piutang Nominal', '/ramwater/piutang/nominal', '#', 'fa-solid fa-cart-flatbed-suitcase',1, 1),
            (25, 25, 19, null, 'Piutang Galon', 'Ramwater Piutang Galon', '/ramwater/piutang/galon', '#', 'fa-solid fa-cart-flatbed-suitcase',2, 1),
            (26, 26, 19, null, 'Laporan Kasbon', 'Ramwater Laporan Kasbon', '/ramwater/laporan/kasbon', '#', 'fa-solid fa-cart-flatbed-suitcase', 4, 1),
            (27, 27, 16, null, 'Input Kasbon', 'Ramwater Input Kasbon', '/ramwater/kasbon', '#', 'fa-solid fa-cart-flatbed-suitcase', 2, 1)
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
            (30, '1', '15', '2024'),
            (31, '99', '16', '2024'),
            (32, '1', '16', '2024'),
            (33, '99', '17', '2024'),
            (34, '1', '17', '2024'),
            (35, '99', '18', '2024'),
            (36, '1', '18', '2024'),
            (37, '99', '19', '2024'),
            (38, '1', '19', '2024'),
            (39, '99', '20', '2024'),
            (40, '1', '20', '2024'),
            (41, '99', '21', '2024'),
            (42, '1', '21', '2024'),
            (43, '99', '22', '2024'),
            (44, '1', '22', '2024'),
            (45, '99', '23', '2024'),
            (46, '1', '23', '2024'),
            (47, '99', '24', '2024'),
            (48, '1', '24', '2024'),
            (49, '99', '25', '2024'),
            (50, '1', '25', '2024'),
            (51, '99', '26', '2024'),
            (52, '1', '26', '2024'),
            (53, '99', '27', '2024'),
            (54, '1', '27', '2024')
        ");
    }
}

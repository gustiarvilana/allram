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
            (23, 23, 19, null, 'Hutang Nominal', 'Ramwater Hutang Nominal', '/ramwater/laporan/hutang/nominal', '#', 'fa-solid fa-cart-flatbed-suitcase',1, 1),
            (24, 24, 19, null, 'Piutang Nominal', 'Ramwater Piutang Nominal', '/ramwater/laporan/piutang/nominal', '#', 'fa-solid fa-cart-flatbed-suitcase',1, 1),
            (25, 25, 19, null, 'Piutang Galon', 'Ramwater Piutang Galon', '/ramwater/laporan/piutang/galon', '#', 'fa-solid fa-cart-flatbed-suitcase',2, 1),
            (26, 26, 19, null, 'Laporan Kasbon', 'Ramwater Laporan Kasbon', '/ramwater/laporan/kasbon', '#', 'fa-solid fa-cart-flatbed-suitcase', 4, 1),
            (27, 27, 16, null, 'Input Kasbon', 'Ramwater Input Kasbon', '/ramwater/kasbon', '#', 'fa-solid fa-cart-flatbed-suitcase', 2, 1),

            (28, 28, 4, null, 'Laporan Harian', 'Ramwater Laporan Harian', '/ramwater/laporan/harian', '#', 'fa-solid fa-cart-flatbed-suitcase', 5, 1),

            (29, 29, 4, null, 'Master', 'Mastering Data ', '#', '#', 'fas fa-wrench', 0, 1),
            (30, 30, 29, null, 'Supplier', 'Supplier Ramwater', '/ramwater/supplier', '#', 'fa-solid fa-cart-flatbed-suitcase', 2, 1),
            (31, 31, 29, null, 'Produk', 'Produk Ramwater', '/ramwater/produk', '#', 'fa-solid fa-cart-flatbed-suitcase', 3, 1)
        ");

        DB::statement("INSERT IGNORE INTO `users_role_menu`
            ( `kd_role`, `kd_menu`, `tahun`)
            VALUES
            ('99', '3', '2024'),
            ('1', '3', '2024'),
            ('99', '9', '2024'),
            ('1', '9', '2024'),
            ('99', '10', '2024'),
            ('1', '10', '2024'),
            ('99', '11', '2024'),
            ('1', '11', '2024'),
            ('99', '12', '2024'),
            ('1', '12', '2024'),
            ('99', '13', '2024'),
            ('1', '13', '2024'),
            ('99', '14', '2024'),
            ('1', '14', '2024'),
            ('99', '15', '2024'),
            ('1', '15', '2024'),
            ('99', '16', '2024'),
            ('1', '16', '2024'),
            ('99', '17', '2024'),
            ('1', '17', '2024'),
            ('99', '18', '2024'),
            ('1', '18', '2024'),
            ('99', '19', '2024'),
            ('1', '19', '2024'),
            ('99', '20', '2024'),
            ('1', '20', '2024'),
            ('99', '21', '2024'),
            ('1', '21', '2024'),
            ('99', '22', '2024'),
            ('1', '22', '2024'),
            ('99', '23', '2024'),
            ('1', '23', '2024'),
            ('99', '24', '2024'),
            ('1', '24', '2024'),
            ('99', '25', '2024'),
            ('1', '25', '2024'),
            ('99', '26', '2024'),
            ('1', '26', '2024'),
            ('99', '27', '2024'),
            ('1', '27', '2024'),
            ('99', '28', '2024'),
            ('1', '28', '2024'),
            ('99', '29', '2024'),
            ('1', '29', '2024'),
            ('99', '30', '2024'),
            ('1', '30', '2024'),
            ('99', '31', '2024'),
            ('1', '31', '2024')
        ");
    }
}

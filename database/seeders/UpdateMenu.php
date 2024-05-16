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
            (18, 18, 12, null, 'Penyerahan', 'Ramwater Penyerahan', '/ramwater/penjualan/penyerahan', '#', 'fa-solid fa-cart-flatbed-suitcase', 5, 1),
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
            (31, 31, 29, null, 'Produk', 'Produk Ramwater', '/ramwater/produk', '#', 'fa-solid fa-cart-flatbed-suitcase', 3, 1),
            (32, 32, 12, null, 'Pengembalian Galon', 'Ramwater Pengembalian Galon', '/ramwater/penjualan/pengembalian/galon', '#', 'ri-calendar-todo-line', 4, 1)
        ");

        DB::statement("INSERT IGNORE INTO `users_role_menu`
            ( `id`,`kd_role`, `kd_menu`, `tahun`)
            VALUES
            (1,'99', '1', '2024'),
            (2,'1', '1', '2024'),
            (3,'99', '2', '2024'),
            (4,'1', '2', '2024'),
            (5,'99', '3', '2024'),
            (6,'1', '3', '2024'),
            (7,'99', '4', '2024'),
            (8,'1', '4', '2024'),
            (9,'99', '5', '2024'),
            (10,'1', '5', '2024'),
            (11,'99', '6', '2024'),
            (12,'1', '6', '2024'),
            (13,'99', '7', '2024'),
            (14,'1', '7', '2024'),
            (15,'99', '8', '2024'),
            (16,'1', '8', '2024'),
            (17,'99', '9', '2024'),
            (18,'1', '9', '2024'),

            (19,'1', '9', '2024'),
            (20,'99', '10', '2024'),
            (21,'1', '10', '2024'),
            (22,'99', '11', '2024'),
            (23,'1', '11', '2024'),
            (24,'99', '12', '2024'),
            (25,'1', '12', '2024'),
            (26,'99', '13', '2024'),
            (27,'1', '13', '2024'),
            (28,'99', '14', '2024'),
            (29,'1', '14', '2024'),
            (30,'99', '15', '2024'),
            (31,'1', '15', '2024'),
            (32,'99', '16', '2024'),
            (33,'1', '16', '2024'),
            (34,'99', '17', '2024'),
            (35,'1', '17', '2024'),
            (36,'99', '18', '2024'),
            (37,'1', '18', '2024'),
            (38,'99', '19', '2024'),
            (39,'1', '19', '2024'),
            (40,'99', '20', '2024'),
            (41,'1', '20', '2024'),
            (42,'99', '21', '2024'),
            (43,'1', '21', '2024'),
            (44,'99', '22', '2024'),
            (45,'1', '22', '2024'),
            (46,'99', '23', '2024'),
            (47,'1', '23', '2024'),
            (48,'99', '24', '2024'),
            (49,'1', '24', '2024'),
            (50,'99', '25', '2024'),
            (51,'1', '25', '2024'),
            (52,'99', '26', '2024'),
            (53,'1', '26', '2024'),
            (54,'99', '27', '2024'),
            (55,'1', '27', '2024'),
            (56,'99', '28', '2024'),
            (57,'1', '28', '2024'),
            (58,'99', '29', '2024'),
            (59,'1', '29', '2024'),
            (60,'99', '30', '2024'),
            (61,'1', '30', '2024'),
            (62,'99', '31', '2024'),
            (63,'1', '31', '2024'),
            (64,'99', '32', '2024'),
            (65,'1', '32', '2024'),
            (66,'2', '32', '2024')
        ");
    }
}

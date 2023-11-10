<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     DB::statement("ALTER TABLE `ramwater_d_penjualan` ADD IF NOT EXISTS `transfer` int(11) UNSIGNED DEFAULT NULL AFTER `cash`;");
    //     DB::statement("ALTER TABLE `ramwater_d_penjualan` ADD IF NOT EXISTS `sisa` int(11) UNSIGNED DEFAULT NULL AFTER `jumlah`;");

    //     DB::statement("ALTER TABLE ramwater_d_galon DROP COLUMN IF EXISTS id_penjualan;");
    //     DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `nik` varchar() UNSIGNED DEFAULT NULL BEFORE `nama`;");
    // }

    public function run()
    {
        DB::statement("ALTER TABLE `ramwater_d_penjualan` ADD IF NOT EXISTS `transfer` int(11) DEFAULT NULL AFTER `cash`;");
        DB::statement("ALTER TABLE `ramwater_d_penjualan` ADD IF NOT EXISTS `sisa` int(11) DEFAULT NULL AFTER `jumlah`;");

        DB::statement("ALTER TABLE `ramwater_d_galon` DROP COLUMN IF EXISTS `id_penjualan`;");
        DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `tanggal` int(11) DEFAULT NULL AFTER `id`;");
        DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `nik` varchar(255) DEFAULT NULL AFTER `tanggal`;");
        DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `alamat` varchar(255) DEFAULT NULL AFTER `jumlah`;");
        DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `hp` varchar(255) DEFAULT NULL AFTER `alamat`;");
        DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `id_parent` int(11) DEFAULT NULL AFTER `id`;");
        DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `bayar` int(11) DEFAULT NULL AFTER `hp`;");
        DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `sts` varchar(1) DEFAULT NULL AFTER `tgl_kembali`;");

        DB::statement("CREATE TABLE IF NOT EXISTS `ramwater_d_hutang` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `tanggal` int(11) DEFAULT NULL,
                    `nik` varchar(255) DEFAULT NULL,
                    `nama` varchar(255) NOT NULL,
                    `jumlah` int(11) NOT NULL,
                    `alamat` TEXT DEFAULT NULL,
                    `hp` varchar(255) DEFAULT NULL,
                    `tgl_kembali` int(11) DEFAULT NULL,
                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
        DB::statement("ALTER TABLE `ramwater_d_hutang` ADD IF NOT EXISTS `id_parent` int(11) DEFAULT NULL AFTER `id`;");
        DB::statement("ALTER TABLE `ramwater_d_hutang` ADD IF NOT EXISTS `bayar` int(11) DEFAULT NULL AFTER `hp`;");
        DB::statement("ALTER TABLE `ramwater_d_hutang` ADD IF NOT EXISTS `sts` varchar(1) DEFAULT NULL AFTER `tgl_kembali`;");

        DB::statement("CREATE TABLE IF NOT EXISTS `d_kasbon` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `id_parent` int(11) DEFAULT NULL,
                    `satker` varchar(255) DEFAULT NULL,
                    `tanggal` int(11) DEFAULT NULL,
                    `nik` varchar(255) DEFAULT NULL,
                    `jumlah` int(11) NOT NULL,
                    `bayar` int(11) DEFAULT NULL,
                    `catatan` text DEFAULT NULL,
                    `sts` varchar(1) DEFAULT NULL,
                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
}

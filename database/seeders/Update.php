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

        DB::statement(
            "CREATE TABLE IF NOT EXISTS `ramwater_d_hutang` (
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
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );
        DB::statement("ALTER TABLE `ramwater_d_hutang` ADD IF NOT EXISTS `id_parent` int(11) DEFAULT NULL AFTER `id`;");
        DB::statement("ALTER TABLE `ramwater_d_hutang` ADD IF NOT EXISTS `bayar` int(11) DEFAULT NULL AFTER `hp`;");
        DB::statement("ALTER TABLE `ramwater_d_hutang` ADD IF NOT EXISTS `sts` varchar(1) DEFAULT NULL AFTER `tgl_kembali`;");

        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_kasbon` (
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
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        DB::statement("INSERT IGNORE INTO `users_menu`
            (`id`, `kd_menu`, `kd_parent`, `type`, `ur_menu_title`, `ur_menu_desc`, `link_menu`, `bg_color`, `icon`, `order`, `is_active`)
            VALUES
            (20, 20, 4, null, 'Pinjaman', 'Pinjaman', '#', 'bg_color', 'fas fa-random', 19, 1),
            (21, 21, 20, null, 'Laporan', 'Pinjaman', '/ramwater/pinjaman/laporan', 'bg_color', 'fas fa-random', 20, 1),
            (22, 22, 20, null, 'Input Pinjaman', 'Pinjaman', '/ramwater/pinjaman', 'bg_color', 'fas fa-random', 21, 1),
            (23, 23, 12, null, 'Pinjam Galon', 'Pinjaman Galon', '/ramwater/penjualan/galon', 'bg_color', 'fas fa-random', 23, 1),
            (24, 24, 12, null, 'Pending Bayar', 'Pending Uang', '/ramwater/penjualan/hutang', 'bg_color', 'fas fa-random', 24, 1)
        ");

        DB::statement("INSERT IGNORE INTO `users_role_menu`
            (`id`, `kd_role`, `kd_menu`, `tahun`)
            VALUES
            (53, '99', '20', '2023'),
            (54, '99', '21', '2023'),
            (55, '99', '22', '2023'),
            (56, '1', '20', '2023'),
            (57, '1', '21', '2023'),
            (58, '1', '22', '2023'),
            (59, '2', '20', '2023'),
            (60, '2', '21', '2023'),
            (61, '2', '22', '2023'),
            (61, '99', '23', '2023'),
            (62, '99', '24', '2023'),
            (63, '1', '23', '2023'),
            (64, '1', '24', '2023'),
            (65, '2', '23', '2023'),
            (66, '2', '24', '2023')
        ");

        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_pinjaman` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `id_parent` int(11) DEFAULT NULL,
                    `satker` varchar(255) DEFAULT NULL,
                    `tanggal` int(11) DEFAULT NULL,
                    `nik` varchar(255) DEFAULT NULL,
                    `jumlah` int(11) NOT NULL,
                    `jml_angs` int(11) NOT NULL,
                    `bayar` int(11) DEFAULT NULL,
                    `catatan` text DEFAULT NULL,
                    `sts` varchar(1) DEFAULT NULL,
                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        DB::statement("ALTER TABLE `t_karyawan` ADD IF NOT EXISTS `jabatan` varchar(11) DEFAULT NULL AFTER `satker`;");

        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_gaji` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `id_parent` int(11) DEFAULT NULL,
                    `satker` varchar(50) DEFAULT NULL,
                    `nik` int(11) DEFAULT NULL,
                    `gapok` int(11) DEFAULT NULL,
                    `kehadiran` int(11) DEFAULT NULL,
                    `tnj_jabatan` int(11) DEFAULT NULL,
                    `total` int(11) DEFAULT NULL,
                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    FOREIGN KEY (`nik`) REFERENCES `t_karyawan` (`nik`) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );
    }
}

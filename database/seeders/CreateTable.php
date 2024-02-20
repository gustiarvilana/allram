<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // d_supplier
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_supplier` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `kd_supplier` varchar(50) DEFAULT NULL,
                    `nama` varchar(50) DEFAULT NULL,
                    `merek` varchar(50) DEFAULT NULL,
                    `alamat` varchar(50) DEFAULT NULL,
                    `kd_kec` int(11) DEFAULT NULL,
                    `kd_kel` int(11) DEFAULT NULL,
                    `kd_kota` int(11) DEFAULT NULL,
                    `kd_pos` int(11) DEFAULT NULL,
                    `norek` varchar(50) DEFAULT NULL,
                    `nama_bank` varchar(50) DEFAULT NULL,
                    `nama_pemilik` varchar(50) DEFAULT NULL,
                    `nama_personal` varchar(50) DEFAULT NULL,
                    `no_tlp` varchar(13) DEFAULT NULL,
                    `opr_input` varchar(50) DEFAULT NULL,
                    `tgl_input` int(11) DEFAULT NULL,

                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // t_gudang
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `t_gudang` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `kd_gudang` varchar(50) DEFAULT NULL,
                    `nama` varchar(50) DEFAULT NULL,
                    `alamat` varchar(50) DEFAULT NULL,
                    `kd_kec`  int(11) DEFAULT NULL,
                    `kd_kel`  int(11) DEFAULT NULL,
                    `kd_kota`  int(11) DEFAULT NULL,
                    `kd_pos`  int(11) DEFAULT NULL,
                    `adm_gudang` varchar(50) DEFAULT NULL,

                    `opr_input` varchar(50) DEFAULT NULL,
                    `tgl_input` int(11) DEFAULT NULL,

                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // t_stok_produk
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `t_stok_produk` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `kd_produk` varchar(255) NOT NULL,
                    `nama` varchar(50) DEFAULT NULL,
                    `kd_gudang` varchar(50) DEFAULT NULL,
                    `stok` int(11) DEFAULT NULL,
                    `opr_input` varchar(50) DEFAULT NULL,
                    `tgl_input` int(11) DEFAULT NULL,

                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // d_pelanggan
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_pelanggan` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `kd_pelanggan` varchar(50) DEFAULT NULL,
                    `nama` varchar(50) DEFAULT NULL,
                    `alamat` varchar(50) DEFAULT NULL,
                    `kd_kec` int(11) DEFAULT NULL,
                    `kd_kel` int(11) DEFAULT NULL,
                    `kd_kota` int(11) DEFAULT NULL,
                    `kd_pos` int(11) DEFAULT NULL,
                    `no_tlp` varchar(13) DEFAULT NULL,
                    `opr_input` varchar(50) DEFAULT NULL,
                    `tgl_input` int(11) DEFAULT NULL,

                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // t_harga_jual
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `t_harga_jual` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `kd_harga` varchar(50) DEFAULT NULL,
                    `kd_produk` varchar(50) DEFAULT NULL,
                    `ket_harga` varchar(50) DEFAULT NULL,
                    `harga` int(11) DEFAULT NULL,
                    `satuan` varchar(50) DEFAULT NULL,
                    `opr_input` varchar(50) DEFAULT NULL,
                    `tgl_input` int(11) DEFAULT NULL,

                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    INDEX `idx_kd_produk` (`kd_produk`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // d_pembelian
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_pembelian` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `kd_harga` varchar(50) DEFAULT NULL,
                    `kd_produk` varchar(50) DEFAULT NULL,
                    `ket_harga` varchar(50) DEFAULT NULL,
                    `harga` int(11) DEFAULT NULL,
                    `satuan` varchar(50) DEFAULT NULL,
                    `opr_input` varchar(50) DEFAULT NULL,
                    `tgl_input` int(11) DEFAULT NULL,

                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    INDEX `idx_kd_produk` (`kd_produk`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );
    }
}

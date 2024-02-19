<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // t_supplier
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `t_supplier` (
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

        // t_master_produk
        DB::statement(
            "ALTER TABLE `t_master_produk`
            ADD IF NOT EXISTS `kd_supplier` varchar(11) DEFAULT NULL AFTER `type`,
            ADD IF NOT EXISTS `stok_all` int(11) DEFAULT NULL AFTER `kd_supplier`,
            ADD IF NOT EXISTS `opr_input` varchar(11) DEFAULT NULL AFTER `stok_all`,
            ADD IF NOT EXISTS `tgl_input` int(11) DEFAULT NULL AFTER `opr_input`,
            ADD IF NOT EXISTS `harga_beli` int(11) DEFAULT NULL AFTER `tgl_input`;"
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

        // t_pelanggan
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `t_pelanggan` (
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

        // t_operasional
        DB::statement(
            "ALTER TABLE `t_operasional`
            ADD IF NOT EXISTS `tipe` varchar(11) DEFAULT NULL AFTER `nama_operasional`,
            ADD IF NOT EXISTS `opr_input` varchar(11) DEFAULT NULL AFTER `tipe`,
            ADD IF NOT EXISTS `tgl_input` int(11) DEFAULT NULL AFTER `opr_input`;"
        );

        // t_karyawan
        DB::statement(
            "ALTER TABLE `t_karyawan`
            ADD IF NOT EXISTS `kd_kec` int(11) DEFAULT NULL AFTER `alamat`,
            ADD IF NOT EXISTS `kd_kel` int(11) DEFAULT NULL NULL AFTER `kd_kec`,
            ADD IF NOT EXISTS `kd_kota` int(11) DEFAULT NULL NULL AFTER `kd_kel`,
            ADD IF NOT EXISTS `kd_pos` int(11) DEFAULT NULL NULL AFTER `kd_kota`,
            ADD IF NOT EXISTS `tgl_masuk` int(11) DEFAULT NULL AFTER `reference`,
            ADD IF NOT EXISTS `tgl_keluar` int(11) DEFAULT NULL AFTER `tgl_masuk`,
            ADD IF NOT EXISTS `sts_karyawan` varchar(11) DEFAULT NULL AFTER `tgl_keluar`,
            ADD IF NOT EXISTS `opr_input` varchar(11) DEFAULT NULL AFTER `sts_karyawan`,
            ADD IF NOT EXISTS `tgl_input` int(11) DEFAULT NULL AFTER `opr_input`,
            ADD IF NOT EXISTS `jabatan` varchar(11) DEFAULT NULL AFTER `satker`;"

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
    }
}

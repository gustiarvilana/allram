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

        // d_stok_produk
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_stok_produk` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `kd_produk` varchar(255) NOT NULL,
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
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `nota_pembelian` VARCHAR(50) NOT NULL,
                `tgl_pembelian` INT DEFAULT NULL,
                `kd_supplier` VARCHAR(50) DEFAULT NULL,
                `jns_pembelian` VARCHAR(50) DEFAULT NULL,
                `harga_total` BIGINT DEFAULT NULL,
                `nominal_bayar` BIGINT DEFAULT NULL,
                `sisa_bayar` BIGINT DEFAULT NULL,
                `sts_angsuran` VARCHAR(50) DEFAULT NULL,
                `opr_input` VARCHAR(50) DEFAULT NULL,
                `tgl_input` INT DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_nota_pembelian` (`nota_pembelian`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // d_pembelian_detail
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_pembelian_detail` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `nota_pembelian` VARCHAR(50) NOT NULL,
                `kd_produk` VARCHAR(50) DEFAULT NULL,
                `qty_pesan` VARCHAR(50) DEFAULT NULL,
                `qty_retur` INT DEFAULT NULL,
                `qty_bersih` INT DEFAULT NULL,
                `harga_satuan` INT DEFAULT NULL,
                `harga_total` BIGINT DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_nota_pembelian_detail` (`nota_pembelian`),
                CONSTRAINT `fk_nota_pembelian_detail` FOREIGN KEY (`nota_pembelian`) REFERENCES `d_pembelian` (`nota_pembelian`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // d_penjualan
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_penjualan` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,

                `nota_penjualan` VARCHAR(50) DEFAULT NULL,
                `tgl_penjualan` VARCHAR(50) NOT NULL,
                `kd_pelanggan` VARCHAR(50) DEFAULT NULL,
                `kd_channel` VARCHAR(50) DEFAULT NULL,
                `harga_total` VARCHAR(50) DEFAULT NULL,
                `nominal_bayar` VARCHAR(50) DEFAULT NULL,
                `sisa_bayar` VARCHAR(50) DEFAULT NULL,
                `sts_angsuran` VARCHAR(50) DEFAULT NULL,
                `total_galon` VARCHAR(50) DEFAULT NULL,
                `galon_kembali` VARCHAR(50) DEFAULT NULL,
                `sisa_galon` VARCHAR(50) DEFAULT NULL,
                `sts_galon` VARCHAR(50) DEFAULT NULL,
                `kd_sales` VARCHAR(50) DEFAULT NULL,

                `opr_input` VARCHAR(50) DEFAULT NULL,
                `tgl_input` INT DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_nota_penjualan` (`nota_penjualan`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // d_penjualan_detail
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_penjualan_detail` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,

                `nota_penjualan` VARCHAR(50) NOT NULL,
                `kd_produk` VARCHAR(50) NOT NULL,
                `qty_pesan` VARCHAR(50) NOT NULL,
                `qty_retur` INT NOT NULL,
                `qty_bersih` INT NOT NULL,
                `kd_gudang` INT NOT NULL,
                `harga_satuan` INT NOT NULL,
                `harga_total` BIGINT NOT NULL,

                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                CONSTRAINT `fk_d_penjualan_detail_nota_penjualan` FOREIGN KEY (`nota_penjualan`) REFERENCES `d_penjualan` (`nota_penjualan`) ON DELETE CASCADE,
                INDEX `idx_nota_penjualan_detail` (`nota_penjualan`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // d_transaksi_ops
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_transaksi_ops` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `nota_pembelian` varchar(50) DEFAULT NULL,
                `tgl_transaksi` INT DEFAULT NULL,
                `kd_ops` varchar(50) DEFAULT NULL,
                `jns_trs` varchar(50) DEFAULT NULL,
                `nominal` INT DEFAULT NULL,
                `ket_transaksi` TEXT DEFAULT NULL,

                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_d_transaksi_nota_pembelian` (`nota_pembelian`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // t_jns_ops
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `t_jns_ops` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

                `kd_jns_ops` varchar(50) DEFAULT NULL,
                `ur_jns_ops` varchar(50) DEFAULT NULL,

                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_t_jns_ops_kd` (`kd_jns_ops`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // t_channel_bayar
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `t_channel_bayar` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

                `kd_channel` varchar(50) DEFAULT NULL,
                `ur_channel` varchar(50) DEFAULT NULL,

                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_t_channel_bayar_kd_channel` (`kd_channel`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // d_pembayaran
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_pembayaran` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `nota` VARCHAR(50) DEFAULT NULL,
                `jns_nota` VARCHAR(50) DEFAULT NULL,
                `tgl` INT DEFAULT NULL,
                `angs_ke` INT DEFAULT NULL,
                `nominal_bayar` INT DEFAULT NULL,
                `channel_bayar` VARCHAR(50) DEFAULT NULL,
                `ket_bayar` TEXT DEFAULT NULL,
                `jns_pembayaran` INT DEFAULT NULL,
                `path_file` TEXT DEFAULT NULL,
                `opr_input` VARCHAR(50) DEFAULT NULL,
                `tgl_input` INT DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_nota_pembayaran` (`nota`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // d_pembayaran_galon
        DB::statement(
            "CREATE TABLE IF NOT EXISTS `d_pembayaran_galon` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `nota` VARCHAR(50) DEFAULT NULL,
                `jns_nota` VARCHAR(50) DEFAULT NULL,
                `tgl` INT DEFAULT NULL,
                `angs_ke` INT DEFAULT NULL,
                `galon_bayar` INT DEFAULT NULL,
                `ket_bayar` TEXT DEFAULT NULL,
                `jns_pembayaran` INT DEFAULT NULL,
                `opr_input` VARCHAR(50) DEFAULT NULL,
                `tgl_input` INT DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_nota_pembayaran` (`nota`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
        );

        // d_kasbon
        DB::statement("
            CREATE TABLE IF NOT EXISTS `d_kasbon` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `nik` VARCHAR(11) DEFAULT NULL,
                `tgl_kasbon` INT(11) DEFAULT NULL,
                `kd_jns_kasbon` INT(11) DEFAULT NULL,
                `nota_penjualan` VARCHAR(50) DEFAULT NULL,
                `nominal` INT(11) DEFAULT NULL,
                `ket_kasbon` TEXT DEFAULT NULL,
                `opr_input` VARCHAR(50) DEFAULT NULL,
                `tgl_input` INT DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_nota_penjualan` (`nota_penjualan`),
                INDEX `idx_nik` (`nik`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
        ");


        // t_jns_kasbon
        DB::unprepared("
            CREATE TABLE IF NOT EXISTS `t_jns_kasbon` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `jns_kasbon` INT DEFAULT NULL,
                `nama` VARCHAR(50) DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_kd_jns_kasbon` (`kd_jns_kasbon`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

            INSERT IGNORE INTO `t_jns_kasbon`
            (`kd_jns_kasbon`, `nama`, `created_at`, `updated_at`)
            VALUES
            (1, 'kasbon Rutin', NOW(), NOW()),
            (2, 'Kasbon Kurang Harga', NOW(), NOW());
        ");

        // t_sts
        DB::unprepared("
            CREATE TABLE IF NOT EXISTS `t_sts` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `kd_sts` INT DEFAULT NULL,
                `nama` VARCHAR(50) DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_kd_sts` (`kd_sts`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

            INSERT IGNORE INTO `t_sts`
            (`kd_sts`, `nama`, `created_at`, `updated_at`)
            VALUES
            (1, 'Aktif Rutin', NOW(), NOW()),
            (3, 'Kasbon Kurang Harga', NOW(), NOW()),
            (4, 'Lunas', NOW(), NOW());
        ");
    }
}

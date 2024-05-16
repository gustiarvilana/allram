<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Mengatur mode SQL
        DB::statement("SET sql_mode = 'ONLY_FULL_GROUP_BY'");

        // t_ops
        $this->addColumns('t_ops', [
            'tipe' => "ALTER TABLE `t_ops` ADD `tipe` varchar(11) DEFAULT NULL AFTER `nama_ops`",
            'opr_input' => "ALTER TABLE `t_ops` ADD `opr_input` varchar(11) DEFAULT NULL AFTER `tipe`",
            'tgl_input' => "ALTER TABLE `t_ops` ADD `tgl_input` int(11) DEFAULT NULL AFTER `opr_input`"
        ]);

        // d_ops
        $this->addColumns('d_ops', [
            'nota' => "ALTER TABLE `d_ops` ADD `nota` varchar(50) DEFAULT NULL AFTER `id`",
            'path_file' => "ALTER TABLE `d_ops` ADD `path_file` TEXT DEFAULT NULL AFTER `total`"
        ]);

        // t_karyawan
        $this->addColumns('d_karyawan', [
            'kd_kec' => "ALTER TABLE `d_karyawan` ADD `kd_kec` int(11) DEFAULT NULL AFTER `alamat`",
            'kd_kel' => "ALTER TABLE `d_karyawan` ADD `kd_kel` int(11) DEFAULT NULL AFTER `kd_kec`",
            'kd_kota' => "ALTER TABLE `d_karyawan` ADD `kd_kota` int(11) DEFAULT NULL AFTER `kd_kel`",
            'kd_pos' => "ALTER TABLE `d_karyawan` ADD `kd_pos` int(11) DEFAULT NULL AFTER `kd_kota`",
            'tgl_masuk' => "ALTER TABLE `d_karyawan` ADD `tgl_masuk` int(11) DEFAULT NULL AFTER `reference`",
            'tgl_keluar' => "ALTER TABLE `d_karyawan` ADD `tgl_keluar` int(11) DEFAULT NULL AFTER `tgl_masuk`",
            'sts_karyawan' => "ALTER TABLE `d_karyawan` ADD `sts_karyawan` varchar(11) DEFAULT NULL AFTER `tgl_keluar`",
            'opr_input' => "ALTER TABLE `d_karyawan` ADD `opr_input` varchar(11) DEFAULT NULL AFTER `sts_karyawan`",
            'tgl_input' => "ALTER TABLE `d_karyawan` ADD `tgl_input` int(11) DEFAULT NULL AFTER `opr_input`",
            'jabatan' => "ALTER TABLE `d_karyawan` ADD `jabatan` varchar(11) DEFAULT NULL AFTER `satker`"
        ]);

        // t_master_produk
        $this->addColumns('t_master_produk', [
            'kd_supplier' => "ALTER TABLE `t_master_produk` ADD `kd_supplier` varchar(11) DEFAULT NULL AFTER `type`",
            'stok_all' => "ALTER TABLE `t_master_produk` ADD `stok_all` int(11) DEFAULT NULL AFTER `kd_supplier`",
            'kd_ops' => "ALTER TABLE `t_master_produk` ADD `kd_ops` int(11) DEFAULT NULL AFTER `stok_all`",
            'opr_input' => "ALTER TABLE `t_master_produk` ADD `opr_input` varchar(11) DEFAULT NULL AFTER `kd_ops`",
            'tgl_input' => "ALTER TABLE `t_master_produk` ADD `tgl_input` int(11) DEFAULT NULL AFTER `opr_input`",
            'harga_beli' => "ALTER TABLE `t_master_produk` ADD `harga_beli` int(11) DEFAULT NULL AFTER `tgl_input`"
        ]);

        // d_pembelian
        $this->addColumns('d_pembelian', [
            'path_file' => "ALTER TABLE `d_pembelian` ADD `path_file` TEXT DEFAULT NULL AFTER `sts_angsuran`"
        ]);

        // d_pembelian_detail
        $this->addColumns('d_pembelian_detail', [
            'kd_gudang' => "ALTER TABLE `d_pembelian_detail` ADD `kd_gudang` varchar(50) DEFAULT NULL AFTER `harga_total`"
        ]);

        // d_supplier
        $this->addColumns('d_supplier', [
            'kd_ops' => "ALTER TABLE `d_supplier` ADD `kd_ops` varchar(50) DEFAULT NULL AFTER `no_tlp`"
        ]);

        // d_penjualan
        $this->addColumns('d_penjualan', [
            'sts_penyerahan' => "ALTER TABLE `d_penjualan` ADD `sts_penyerahan` INT DEFAULT 0 AFTER `sts_angsuran`",
            'path_file' => "ALTER TABLE `d_penjualan` ADD `path_file` INT DEFAULT 0 AFTER `tgl_input`"
        ]);
    }

    /**
     * Tambahkan kolom ke tabel jika kolom belum ada
     *
     * @param string $tableName
     * @param array $columns
     * @return void
     */
    protected function addColumns(string $tableName, array $columns)
    {
        foreach ($columns as $column => $alterQuery) {
            if (!Schema::hasColumn($tableName, $column)) {
                DB::statement($alterQuery);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlterTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // t_ops
        DB::statement(
            "ALTER TABLE `t_ops`
            ADD IF NOT EXISTS `tipe` varchar(11) DEFAULT NULL AFTER `nama_ops`,
            ADD IF NOT EXISTS `opr_input` varchar(11) DEFAULT NULL AFTER `tipe`,
            ADD IF NOT EXISTS `tgl_input` int(11) DEFAULT NULL AFTER `opr_input`;"
        );

        // t_karyawan
        DB::statement(
            "ALTER TABLE `d_karyawan`
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

        // t_master_produk
        DB::statement(
            "ALTER TABLE `t_master_produk`
            ADD IF NOT EXISTS `kd_supplier` varchar(11) DEFAULT NULL AFTER `type`,
            ADD IF NOT EXISTS `stok_all` int(11) DEFAULT NULL AFTER `kd_supplier`,
            ADD IF NOT EXISTS `opr_input` varchar(11) DEFAULT NULL AFTER `stok_all`,
            ADD IF NOT EXISTS `tgl_input` int(11) DEFAULT NULL AFTER `opr_input`,
            ADD IF NOT EXISTS `harga_beli` int(11) DEFAULT NULL AFTER `tgl_input`;"
        );

        DB::statement(
            "ALTER TABLE `d_pembelian`
            ADD IF NOT EXISTS `path_file` TEXT DEFAULT NULL AFTER `sts_angsuran`;"
        );

        DB::statement(
            "ALTER TABLE `d_pembelian_detail`
            ADD IF NOT EXISTS `kd_gudang` varchar(50) DEFAULT NULL AFTER `harga_total`
            ;"
        );

        DB::statement(
            "ALTER TABLE `d_supplier`
            ADD IF NOT EXISTS `kd_ops` varchar(50) DEFAULT NULL AFTER `no_tlp`
            ;"
        );
    }
}

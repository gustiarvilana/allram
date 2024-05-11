<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateView extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("CREATE OR REPLACE VIEW view_penjualan_by_produk AS
            SELECT
                b.tgl_penjualan,
                b.kd_pelanggan,
                b.kd_sales,
                a.kd_produk,
                a.qty_bersih,
                a.harga_satuan,
                a.harga_total
            FROM
                `d_penjualan_detail` a
            JOIN
                `d_penjualan` b ON a.`nota_penjualan` = b.`nota_penjualan`
            GROUP BY
                b.tgl_penjualan, b.`kd_pelanggan`, a.kd_produk,a.qty_bersih,a.harga_satuan,a.harga_total,b.kd_sales;
        ");

        DB::statement("CREATE OR REPLACE VIEW view_pembayaran_penjualan AS
            SELECT
                a.tgl,
                b.kd_pelanggan,
                b.nota_penjualan,
                a.jns_nota,
                a.angs_ke,
                a.channel_bayar,
                SUM(a.`nominal_bayar`) AS nominal_bayar
            FROM
                `d_pembayaran` a
            JOIN
                `d_penjualan` b ON a.`nota` = b.`nota_penjualan` AND b.`tgl_penjualan` = a.tgl
            WHERE
                a.channel_bayar IN (1,2,3)
                AND a.angs_ke = 1
            GROUP BY
                a.tgl, b.kd_pelanggan,b.nota_penjualan,a.angs_ke,a.jns_nota,a.channel_bayar;
        ");

        DB::statement("CREATE OR REPLACE VIEW view_pembayaran_piutang_nominal AS
            SELECT
                a.tgl,
                b.kd_pelanggan,
                b.nota_penjualan,
                a.jns_nota,
                a.angs_ke,
                a.channel_bayar,
                SUM(a.`nominal_bayar`) AS total_bayar
            FROM
                `d_pembayaran` a
            JOIN
                `d_penjualan` b ON a.`nota` = b.`nota_penjualan`
            WHERE
                b.`tgl_penjualan` != a.tgl
            GROUP BY
                a.tgl, b.kd_pelanggan, a.angs_ke,b.nota_penjualan,a.jns_nota,a.angs_ke,a.channel_bayar;
        ");
    }
}

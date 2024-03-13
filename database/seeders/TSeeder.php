<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // t_ops
        DB::statement("INSERT IGNORE INTO `t_ops`
            (`id`, `kd_ops`, `nama_ops`, `tipe`, `opr_input`, `tgl_input`, `created_at`, `updated_at`)
            VALUES
            (1, '2100', 'Modal', 'H', 'system', 0, NULL, NULL),
            (2, '2101', 'Modal Di Setor', 'H', 'system', 0, NULL, NULL),
            (3, '4100', 'Pendapatan Penjualan AQUA', 'P', 'system', 0, NULL, NULL),
            (4, '4101', 'Pendapatan Penjualan AQUA GALON AIR', 'P', 'system', 0, NULL, NULL),
            (5, '4102', 'Pendapatan Penjualan AQUA 330 ml', 'P', 'system', 0, NULL, NULL),
            (6, '4103', 'Pendapatan Penjualan AQUA 600 ml', 'P', 'system', 0, NULL, NULL),
            (7, '4104', 'Pendapatan Penjualan AQUA 1500 ml', 'P', 'system', 0, NULL, NULL),
            (8, '4105', 'Pendapatan Penjualan AQUA GALON BOTOL', 'P', 'system', 0, NULL, NULL),
            (9, '4106', 'Pendapatan Penjualan AQUA GALON SET', 'P', 'system', 0, NULL, NULL),
            (10, '4200', 'Pendapatan Penjualan Le Minerale', 'P', 'system', 0, NULL, NULL),
            (11, '4201', 'Pendapatan Penjualan Le Minerale Galon', 'P', 'system', 0, NULL, NULL),
            (12, '4202', 'Pendapatan Penjualan Le Minerale 330 ml', 'P', 'system', 0, NULL, NULL),
            (13, '4203', 'Pendapatan Penjualan Le Minerale 600 ml', 'P', 'system', 0, NULL, NULL),
            (14, '4204', 'Pendapatan Penjualan Le Minerale 1500 ml', 'P', 'system', 0, NULL, NULL),
            (15, '6100', 'Pembayaran Gaji', 'B', 'system', 0, NULL, NULL),
            (16, '6101', 'Pembayaran Gaji ', 'B', 'system', 0, NULL, NULL),
            (17, '6106', 'Pembayaran THR ', 'B', 'system', 0, NULL, NULL),
            (18, '6200', 'Pembayaran Produk', 'B', 'system', 0, NULL, NULL),
            (19, '6201', 'Pemb Produk AQUA', 'B', 'system', 0, NULL, NULL),
            (20, '6202', 'Pemb Produk Le Minerale', 'B', 'system', 0, NULL, NULL),
            (21, '6206', 'Biaya Transfer Bank', 'B', 'system', 0, NULL, NULL),
            (22, '6299', 'Pembayaran Produk Lainnya', 'B', 'system', 0, NULL, NULL),
            (23, '6300', 'Biaya BBM', 'B', 'system', 0, NULL, NULL),
            (24, '6301', 'Biaya BBM Delivery', 'B', 'system', 0, NULL, NULL),
            (25, '6302', 'Biaya BBM Ekspedisi', 'B', 'system', 0, NULL, NULL),
            (26, '6303', 'Biaya BBM Ops Pusat', 'B', 'system', 0, NULL, NULL),
            (27, '6400', 'Biaya OPS', 'B', 'system', 0, NULL, NULL),
            (28, '6401', 'Biaya OPS Ekspedisi', 'B', 'system', 0, NULL, NULL),
            (29, '6402', 'Biaya OPS Keberangkatan', 'B', 'system', 0, NULL, NULL),
            (30, '6403', 'Biaya OPS Kepulangan Delivery', 'B', 'system', 0, NULL, NULL),
            (31, '6404', 'Biaya OPS Pengambilan BRG Delivery', 'B', 'system', 0, NULL, NULL),
            (32, '6405', 'Biaya Pembelian E-tol', 'B', 'system', 0, NULL, NULL),
            (33, '6406', 'Biaya Parkir', 'B', 'system', 0, NULL, NULL),
            (34, '6407', 'Biaya Pungli', 'B', 'system', 0, NULL, NULL),
            (35, '6408', 'Biaya Iuran Keamanan & Kebersihan', 'B', 'system', 0, NULL, NULL),
            (36, '6409', 'Biaya Sumbangan', 'B', 'system', 0, NULL, NULL),
            (37, '6500', 'Pembayaran Angsuran', 'B', 'system', 0, NULL, NULL),
            (38, '6501', 'Pembayaran Angsuran Bank BNI', 'B', 'system', 0, NULL, NULL),
            (39, '6502', 'Pembayaran Angsuran Bank Mandiri', 'B', 'system', 0, NULL, NULL),
            (40, '6503', 'Pembayaran Angsuran Bank NISP', 'B', 'system', 0, NULL, NULL),
            (41, '6505', 'Angsuran Kendaraan', 'B', 'system', 0, NULL, NULL),
            (42, '6800', 'Pembelian Makan dan Minum', 'B', 'system', 0, NULL, NULL),
            (43, '6801', 'Pembelian Air Minum Galon', 'B', 'system', 0, NULL, NULL),
            (44, '6802', 'Pembelian Air Minum Isi Ulang', 'B', 'system', 0, NULL, NULL),
            (45, '6803', 'Pembelian Makanan', 'B', 'system', 0, NULL, NULL),
            (46, '6804', 'Biaya Meeting', 'B', 'system', 0, NULL, NULL),
            (47, '6805', 'Biaya Pelatihan', 'B', 'system', 0, NULL, NULL),
            (48, '6806', 'Pembelian Aqua Botol', 'B', 'system', 0, NULL, NULL),
            (49, '6900', 'Biaya - ATK', 'B', 'system', 0, NULL, NULL),
            (50, '6901', 'Biaya ATK', 'B', 'system', 0, NULL, NULL),
            (51, '6902', 'Biaya Fotocopy', 'B', 'system', 0, NULL, NULL),
            (52, '6903', 'Biaya Print', 'B', 'system', 0, NULL, NULL),
            (53, '6904', 'Pembayaran Percetakan', 'B', 'system', 0, NULL, NULL),
            (54, '6700', 'Biaya Kendaraan', 'B', 'system', 0, NULL, NULL),
            (55, '6701', 'Biaya Kir Kendaraan', 'B', 'system', 0, NULL, NULL),
            (56, '6702', 'Biaya Pajak Kendaraan', 'B', 'system', 0, NULL, NULL),
            (57, '6703', 'Biaya Jasa Service', 'B', 'system', 0, NULL, NULL),
            (58, '6704', 'Pemb.Sparepart', 'B', 'system', 0, NULL, NULL),
            (59, '6709', 'Biaya Cuci Steam', 'B', 'system', 0, NULL, NULL),
            (60, '6600', 'Biaya Listrik, Telp & PAM', 'B', 'system', 0, NULL, NULL),
            (61, '6601', 'Biaya Telp+Indihome', 'B', 'system', 0, NULL, NULL),
            (62, '6602', 'Biaya Listrik', 'B', 'system', 0, NULL, NULL),
            (63, '6603', 'Biaya PDAM', 'B', 'system', 0, NULL, NULL),
            (64, '6900', 'Biaya Gedung', 'B', 'system', 0, NULL, NULL),
            (65, '6901', 'Pembelian Alat Kebersihan', 'B', 'system', 0, NULL, NULL),
            (66, '6902', 'Pembelian Alat Listrik', 'B', 'system', 0, NULL, NULL),
            (67, '6903', 'Pembelian Isi Gas', 'B', 'system', 0, NULL, NULL),
            (68, '6904', 'Biaya Sewa', 'B', 'system', 0, NULL, NULL),
            (69, '6905', 'Perlengkapan Gedung', 'B', 'system', 0, NULL, NULL),
            (70, '6999', 'Biaya Lainnya', 'B', 'system', 0, NULL, NULL)
        ");

        // t_jns_ops
        DB::statement("INSERT IGNORE INTO `t_jns_ops`
            (`id`, `kd_jns_ops`, `ur_jns_ops`, `created_at`, `updated_at`)
            VALUES
            (1, 'P', 'Pendapatan', 'System', 'System'),
            (2, 'B', 'Biaya', 'System', 'System');
        ");

        // t_master_produk
        $this->call(ProdukSeeder::class);

        // users
        $this->call(UserSeeder::class);
    }
}

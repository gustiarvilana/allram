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
            (1, 2100, 'Modal', 'H', 'System', 0, 'System', 'System'),
            (2, 2101, 'Modal Di Setor', 'H', 'System', 0, 'System', 'System'),
            (3, 4100, 'Pendapatan Penjualan', 'P', 'System', 0, 'System', 'System'),
            (4, 4101, 'Pendapatan Penjualan UM+Tunai:Serang', 'P', 'System', 0, 'System', 'System'),
            (5, 4102, 'Pendapatan Penjualan UM+Tunai:Jabar I', 'P', 'System', 0, 'System', 'System'),
            (6, 4103, 'Pendapatan Penjualan UM+Tunai:Jabar II', 'P', 'System', 0, 'System', 'System'),
            (7, 4104, 'Pendapatan Penjualan UM+Tunai:Jateng', 'P', 'System', 0, 'System', 'System'),
            (8, 4105, 'Pend Penjualan UM+Tunai:Ram Electric', 'P', 'System', 0, 'System', 'System'),
            (9, 4200, 'Pendapatan Tagihan', 'P', 'System', 0, 'System', 'System'),
            (10, 4201, 'Pendapatan Tagihan:Jabodetabek', 'P', 'System', 0, 'System', 'System'),
            (11, 4202, 'Pendapatan Tagihan :Jabar 1', 'P', 'System', 0, 'System', 'System'),
            (12, 4203, 'Pendapatan Tagihan:Jabar II', 'P', 'System', 0, 'System', 'System'),
            (13, 4204, 'Pendapatan Tagihan:Jateng', 'P', 'System', 0, 'System', 'System'),
            (14, 4205, 'Pendapatan Tagihan:RAM Electrik', 'P', 'System', 0, 'System', 'System'),
            (15, 4206, 'Pengembalian Dana Anggaran', 'P', 'System', 0, 'System', 'System'),
            (16, 4207, 'Penjualan Sparepat', 'P', 'System', 0, 'System', 'System'),
            (17, 6100, 'Pembayaran Gaji', 'B', 'System', 0, 'System', 'System'),
            (18, 6101, 'Pembayaran Gaji Kantor Pusat', 'B', 'System', 0, 'System', 'System'),
            (19, 6102, 'Pembayaran Gaji CRM', 'B', 'System', 0, 'System', 'System'),
            (20, 6103, 'Pembayaran Gaji Verifikator', 'B', 'System', 0, 'System', 'System'),
            (21, 6104, 'Pembayaran Gaji Delivery', 'B', 'System', 0, 'System', 'System'),
            (22, 6105, 'Pemb Gaji Marketing Jabar&Jabodetabekser', 'B', 'System', 0, 'System', 'System'),
            (23, 6106, 'Pembayaran Gaji Marketing Jateng', 'B', 'System', 0, 'System', 'System'),
            (24, 6107, 'Pembayaran Gaji Marketing Ram Electrik', 'B', 'System', 0, 'System', 'System'),
            (25, 6108, 'Pembayaran Gaji Delivery', 'B', 'System', 0, 'System', 'System'),
            (26, 6109, 'Pembayaran THR Marketing', 'B', 'System', 0, 'System', 'System'),
            (27, 6110, 'Pembayaran Gaji Office Girl', 'B', 'System', 0, 'System', 'System'),
            (28, 6111, 'Pembayaran THR Pusat', 'B', 'System', 0, 'System', 'System'),
            (29, 6112, 'Pembayaran THR CRM + Verif', 'B', 'System', 0, 'System', 'System'),
            (30, 6113, 'Pembayaran THR Delivery', 'B', 'System', 0, 'System', 'System'),
            (31, 6114, 'Pembayaran THR Verifikator', 'B', 'System', 0, 'System', 'System'),
            (32, 6115, 'Pembayaran THR CRM', 'B', 'System', 0, 'System', 'System'),
            (33, 6116, 'Pembayaran THR Karyawan Lainnya', 'B', 'System', 0, 'System', 'System'),
            (34, 6199, 'Pembayaran Gaji Marketing Lainnya', 'B', 'System', 0, 'System', 'System'),
            (35, 6200, 'Pembayaran Produk', 'B', 'System', 0, 'System', 'System'),
            (36, 6201, 'Pemb Produk PT.Bintan Metalindo Sukses', 'B', 'System', 0, 'System', 'System'),
            (37, 6202, 'Pembayaran Produk PT. JE Elexindo', 'B', 'System', 0, 'System', 'System'),
            (38, 6203, 'Pemb Produk PT.Lareching Ang Indonesia', 'B', 'System', 0, 'System', 'System'),
            (39, 6204, 'Pemb. Produk PT.Sumacon Poris Metal', 'B', 'System', 0, 'System', 'System'),
            (40, 6205, 'Pembayaran Perlengkapan Aqua.', 'B', 'System', 0, 'System', 'System'),
            (41, 6206, 'Biaya Transfer Bank', 'B', 'System', 0, 'System', 'System'),
            (42, 6299, 'Pembayaran Produk Lainnya', 'B', 'System', 0, 'System', 'System'),
            (43, 6300, 'Biaya BBM', 'B', 'System', 0, 'System', 'System'),
            (44, 6301, 'Biaya BBM Delivery', 'B', 'System', 0, 'System', 'System'),
            (45, 6302, 'Biaya BBM Ekspedisi', 'B', 'System', 0, 'System', 'System'),
            (46, 6303, 'Biaya BBM Ops Pusat', 'B', 'System', 0, 'System', 'System'),
            (47, 6400, 'Biaya OPS', 'B', 'System', 0, 'System', 'System'),
            (48, 6401, 'Biaya OPS Ekspedisi', 'B', 'System', 0, 'System', 'System'),
            (49, 6402, 'Biaya OPS Keberangkatan', 'B', 'System', 0, 'System', 'System'),
            (50, 6403, 'Biaya OPS Kepulangan Delivery', 'B', 'System', 0, 'System', 'System'),
            (51, 6404, 'Biaya OPS Pengambilan BRG Delivery', 'B', 'System', 0, 'System', 'System'),
            (52, 6499, 'Biaya Pemeliharaan Gedung Kantor', 'B', 'System', 0, 'System', 'System'),
            (53, 6500, 'Pembayaran Angsuran Bank', 'B', 'System', 0, 'System', 'System'),
            (54, 6501, 'Pembayaran Angsuran Bank BNI', 'B', 'System', 0, 'System', 'System'),
            (55, 6502, 'Pembayaran Angsuran Bank Mandiri', 'B', 'System', 0, 'System', 'System'),
            (56, 6503, 'Pembayaran Angsuran Bank NISP', 'B', 'System', 0, 'System', 'System'),
            (57, 6504, 'Pembayaran Angsuran Lainnya', 'B', 'System', 0, 'System', 'System'),
            (58, 6505, 'Biaya Pinjaman Bank', 'B', 'System', 0, 'System', 'System'),
            (59, 6600, 'Angsuran Kendaraan', 'B', 'System', 0, 'System', 'System'),
            (60, 6601, 'Angsuran Kendaran Rubicon', 'B', 'System', 0, 'System', 'System'),
            (61, 6602, 'Angsuran KPR', 'B', 'System', 0, 'System', 'System'),
            (62, 6603, 'Angsuran Kendaraan Mini Cooper', 'B', 'System', 0, 'System', 'System'),
            (63, 6604, 'Pembayaran Asuransi', 'B', 'System', 0, 'System', 'System'),
            (64, 6700, 'Pembayaran Kantor', 'B', 'System', 0, 'System', 'System'),
            (65, 6710, 'Pembayaran Kantor Cabang Jabodetabek', 'B', 'System', 0, 'System', 'System'),
            (66, 6711, 'Pembayaran Kantor Sub Cabang Jabodetabek', 'B', 'System', 0, 'System', 'System'),
            (67, 6720, 'Pembayaran Kantor Cabang Jabar I', 'B', 'System', 0, 'System', 'System'),
            (68, 6721, 'Pembayaran Kantor Sub Cabang Jabar I', 'B', 'System', 0, 'System', 'System'),
            (69, 6730, 'Pembayaran Kantor Cabang Jabar II', 'B', 'System', 0, 'System', 'System'),
            (70, 6731, 'Pembayaran Kantor Sub Cabang Jabar II', 'B', 'System', 0, 'System', 'System'),
            (71, 6740, 'Pembayaran Kantor Cabang Jateng', 'B', 'System', 0, 'System', 'System'),
            (72, 6741, 'Pembayaran Kantor Sub Cabang Jateng', 'B', 'System', 0, 'System', 'System'),
            (73, 6742, 'Pembayaran Umroh', 'B', 'System', 0, 'System', 'System'),
            (74, 6790, 'Pembayaran Basecamp Jabar & Jabode', 'B', 'System', 0, 'System', 'System'),
            (75, 6791, 'Pembayaran Basecamp Jateng', 'B', 'System', 0, 'System', 'System'),
            (76, 6792, 'Pembayaran Basecamp Ram Electric', 'B', 'System', 0, 'System', 'System'),
            (77, 6800, 'Pembelian Makan dan Minum', 'B', 'System', 0, 'System', 'System'),
            (78, 6801, 'Pembelian Air Minum Galon', 'B', 'System', 0, 'System', 'System'),
            (79, 6802, 'Pembelian Air Minum Isi Ulang', 'B', 'System', 0, 'System', 'System'),
            (80, 6803, 'Pembelian Makanan', 'B', 'System', 0, 'System', 'System'),
            (81, 6804, 'Biaya Meeting', 'B', 'System', 0, 'System', 'System'),
            (82, 6805, 'Biaya Pelatihan', 'B', 'System', 0, 'System', 'System'),
            (83, 6806, 'Pembelian Aqua Botol', 'B', 'System', 0, 'System', 'System'),
            (84, 6807, 'Biaya Sumbangan', 'B', 'System', 0, 'System', 'System'),
            (85, 6808, 'Uang Makan', 'B', 'System', 0, 'System', 'System'),
            (86, 6900, 'Biaya - Biaya', 'B', 'System', 0, 'System', 'System'),
            (87, 6901, 'Biaya ATK', 'B', 'System', 0, 'System', 'System'),
            (88, 6902, 'Biaya Fotocopy', 'B', 'System', 0, 'System', 'System'),
            (89, 6903, 'Biaya Print', 'B', 'System', 0, 'System', 'System'),
            (90, 6904, 'Biaya Kir Kendaraan', 'B', 'System', 0, 'System', 'System'),
            (91, 6905, 'Biaya Pajak Kendaraan', 'B', 'System', 0, 'System', 'System'),
            (92, 6906, 'Biaya Pembelian E-tol', 'B', 'System', 0, 'System', 'System'),
            (93, 6907, 'Biaya Bongkar Muat Truk', 'B', 'System', 0, 'System', 'System'),
            (94, 6908, 'Biaya Cuci Steam', 'B', 'System', 0, 'System', 'System'),
            (95, 6909, 'Biaya Telp+Indihome', 'B', 'System', 0, 'System', 'System'),
            (96, 6910, 'Biaya Listrik', 'B', 'System', 0, 'System', 'System'),
            (97, 6911, 'Biaya Iuran Keamanan & Kebersihan', 'B', 'System', 0, 'System', 'System'),
            (98, 6912, 'Biaya PDAM', 'B', 'System', 0, 'System', 'System'),
            (99, 6913, 'Biaya Paket JNE', 'B', 'System', 0, 'System', 'System'),
            (100, 6914, 'Biaya Parkir', 'B', 'System', 0, 'System', 'System'),
            (101, 6915, 'Biaya Potongan Kolektif', 'B', 'System', 0, 'System', 'System'),
            (102, 6916, 'Biaya Pungli', 'B', 'System', 0, 'System', 'System'),
            (103, 6917, 'Biaya Service', 'B', 'System', 0, 'System', 'System'),
            (104, 6918, 'Pemb.Sparepart', 'B', 'System', 0, 'System', 'System'),
            (105, 6919, 'Pembelian Alat Kebersihan', 'B', 'System', 0, 'System', 'System'),
            (106, 6920, 'Pembelian Alat Listrik', 'B', 'System', 0, 'System', 'System'),
            (107, 6921, 'Pembelian Isi Gas', 'B', 'System', 0, 'System', 'System'),
            (108, 6922, 'Pembayaran Percetakan', 'B', 'System', 0, 'System', 'System'),
            (109, 6923, 'Klaim Kesehatan', 'B', 'System', 0, 'System', 'System'),
            (110, 6924, 'Perlengkapan Basecamp', 'B', 'System', 0, 'System', 'System'),
            (111, 6925, 'Biaya Perjalanan Dinas', 'B', 'System', 0, 'System', 'System'),
            (112, 6926, 'Biaya Entertainment', 'B', 'System', 0, 'System', 'System'),
            (113, 6927, 'Rapat dan Pelatihan', 'B', 'System', 0, 'System', 'System'),
            (114, 6928, 'Insentif GM', 'B', 'System', 0, 'System', 'System'),
            (115, 6929, 'Pembayaran PBB (Pajak Bumi dan Bangunan)', 'B', 'System', 0, 'System', 'System'),
            (116, 6930, 'Pembelian Komputer Dan Perlengkapan', 'B', 'System', 0, 'System', 'System'),
            (117, 6931, 'Pembayaran Pajak Lainnya', 'B', 'System', 0, 'System', 'System'),
            (118, 6932, 'Pembelian Perlengkapan Steam', 'B', 'System', 0, 'System', 'System'),
            (119, 6933, 'Biaya Potongan Pelunasan Kuitansi', 'B', 'System', 0, 'System', 'System'),
            (120, 6934, 'Pajak Faspay', 'B', 'System', 0, 'System', 'System'),
            (121, 6935, 'Fee Faspay', 'B', 'System', 0, 'System', 'System'),
            (122, 6936, 'Pajak Faspay', 'B', 'System', 0, 'System', 'System'),
            (123, 6937, 'Pembayaran Pajak PPH (Pajak Penghasilan)', 'B', 'System', 0, 'System', 'System'),
            (124, 6938, 'Biaya Hosting Web', 'B', 'System', 0, 'System', 'System'),
            (125, 6939, 'Biaya Sewa', 'B', 'System', 0, 'System', 'System'),
            (126, 6940, 'Perlengkapan Gedung', 'B', 'System', 0, 'System', 'System'),
            (127, 6999, 'Biaya Lainnya', 'B', 'System', 0, 'System', 'System')
        ");

        // t_transaksi_ops
        DB::statement("INSERT IGNORE INTO `t_transaksi_ops`
            (`id`, `kd_transaksi_ops`, `ur_transaksi_ops`, `created_at`, `updated_at`)
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

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
        DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `nik` varchar(255) DEFAULT NULL AFTER `id`;");
        DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `alamat` varchar(255) DEFAULT NULL AFTER `jumlah`;");
        DB::statement("ALTER TABLE `ramwater_d_galon` ADD IF NOT EXISTS `hp` varchar(255) DEFAULT NULL AFTER `alamat`;");
    }
}

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
        DB::statement("ALTER TABLE `ramwater_d_penjualan` ADD IF NOT EXISTS `transfer` int(11) UNSIGNED DEFAULT NULL AFTER `cash`;");
    }
}

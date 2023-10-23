<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_master_produk')->upsert([
            [
                'kd_produk' => '1',
                'satker'    => 'ramwater',
                'nama'      => 'Aqua Galon SET',
                'merek'     => 'Aqua',
                'type'      => '19L',
            ],
            [
                'kd_produk' => '2',
                'satker'    => 'ramwater',
                'nama'      => 'Aqua Galon Air',
                'merek'     => 'Aqua',
                'type'      => '19L',
            ],
            [
                'kd_produk' => '3',
                'satker'    => 'ramwater',
                'nama'      => 'Aqua Galon Botol',
                'merek'     => 'Aqua',
                'type'      => 'Botol Galon',
            ],
            [
                'kd_produk' => '4',
                'satker'    => 'ramwater',
                'nama'      => 'Lemineral Galon',
                'merek'     => 'Lemineral',
                'type'      => '15L',
            ],
        ], ['kd_produk']);
    }
}

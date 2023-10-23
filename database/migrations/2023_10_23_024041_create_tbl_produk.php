<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_master_produk', function (Blueprint $table) {
            $table->id();
            $table->string('kd_produk')->index();
            $table->string('satker');
            $table->string('nama');
            $table->string('merek');
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('d_datang_barang', function (Blueprint $table) {
            $table->id();
            $table->string('tgl_datang');
            $table->string('nama');
            $table->string('kd_produk');
            $table->integer('jumlah');
            $table->integer('rb');
            $table->timestamps();

            $table->foreign('kd_produk')->references('kd_produk')->on('t_master_produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_produk');
        Schema::dropIfExists('d_datang_barang');
    }
}

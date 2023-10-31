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

        Schema::create('ramwater_d_datang_barang', function (Blueprint $table) {
            $table->id();
            $table->integer('tgl_datang');
            $table->string('nama');
            $table->string('kd_produk');
            $table->integer('jumlah');
            $table->integer('rb')->nullable();
            $table->integer('harga')->nullable();
            $table->integer('total')->nullable();
            $table->timestamps();

            $table->foreign('kd_produk')->references('kd_produk')->on('t_master_produk')->onDelete('cascade');
        });

        Schema::create('ramwater_d_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('tgl_penjualan');
            $table->string('nik');
            $table->string('kd_produk');
            $table->string('jumlah');
            $table->string('galon_kembali')->nullable();
            $table->string('galon_diluar')->nullable();
            $table->string('cash')->nullable();
            $table->timestamps();

            $table->foreign('kd_produk')->references('kd_produk')->on('t_master_produk')->onDelete('cascade');
        });

        Schema::create('ramwater_d_penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_penjualan');
            $table->string('nama');
            $table->integer('jumlah');
            $table->integer('harga')->nullable();
            $table->integer('total')->nullable();
            $table->text('ket')->nullable();
            $table->timestamps();
        });

        Schema::create('ramwater_d_galon', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_penjualan');
            $table->string('nama');
            $table->integer('jumlah');
            $table->integer('tgl_kembali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ramwater_d_galon');
        Schema::dropIfExists('t_produk');
        Schema::dropIfExists('ramwater_d_datang_barang');
        Schema::dropIfExists('ramwater_d_penjualan');
    }
}

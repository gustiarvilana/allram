<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProduk extends Migration
{
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

        Schema::create('t_ops', function (Blueprint $table) {
            $table->id();
            $table->string('kd_ops')->index();
            $table->string('nama_ops');
            $table->timestamps();
        });
        Schema::create('d_ops', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tanggal');
            $table->string('satker');
            $table->string('nik');
            $table->string('kd_ops');
            $table->integer('jumlah');
            $table->integer('harga');
            $table->integer('total');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('kd_ops')->references('kd_ops')->on('t_ops')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_master_produk');
        Schema::dropIfExists('t_ops');
        Schema::dropIfExists('d_ops');
    }
}

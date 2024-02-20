<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_role', function (Blueprint $table) {
            $table->id();
            $table->integer('kd_role')->index();
            $table->string('ur_role')->unique();
            $table->timestamps();
        });

        Schema::create('d_karyawan', function (Blueprint $table) {
            $table->id();
            $table->integer('nik')->index();
            $table->string('nama');
            $table->string('satker')->nullable();
            $table->text('alamat')->nullable();
            $table->string('jk')->nullable();
            $table->string('ktp')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('nik');
            $table->string('username')->unique();
            $table->string('phone')->nullable();
            $table->string('pwd');
            $table->integer('kd_role')->nullable();
            $table->string('active')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('nik')->references('nik')->on('t_karyawan')->onDelete('cascade');
            $table->foreign('kd_role')->references('kd_role')->on('users_role')->onDelete('cascade');
        });

        Schema::create('users_menu', function (Blueprint $table) {
            $table->id();
            $table->integer('kd_menu')->index();
            $table->integer('kd_parent');
            $table->string('type')->nullable();
            $table->string('ur_menu_title');
            $table->string('ur_menu_desc')->nullable();
            $table->string('link_menu')->nullable();
            $table->string('bg_color')->nullable();
            $table->string('icon')->nullable();
            $table->string('order')->nullable();
            $table->string('is_active')->nullable();

            $table->timestamps();
        });

        Schema::create('users_role_menu', function (Blueprint $table) {
            $table->id();
            $table->integer('kd_role');
            $table->integer('kd_menu');
            $table->integer('tahun');

            $table->timestamps();

            $table->foreign('kd_role')->references('kd_role')->on('users_role')->onDelete('cascade');
            $table->foreign('kd_menu')->references('kd_menu')->on('users_menu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_role_menu');
        Schema::dropIfExists('users');
        Schema::dropIfExists('users_menu');
        Schema::dropIfExists('t_karyawan');
        Schema::dropIfExists('users_role');
    }
}

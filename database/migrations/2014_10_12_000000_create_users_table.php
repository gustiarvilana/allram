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

        Schema::create('t_karyawan', function (Blueprint $table) {
            $table->id();
            $table->integer('nik')->index();
            $table->string('nama');
            $table->text('alamat');
            $table->string('jk');
            $table->string('ktp');
            $table->string('no_hp');
            $table->string('reference')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('phone')->nullable();
            $table->string('pwd');
            $table->string('nik')->nullable();
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('users_role');
        Schema::dropIfExists('t_karyawan');
    }
}

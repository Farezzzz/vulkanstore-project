<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->string('nama_lengkap');
            $table->string('role');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status_aktif', ['Aktif', 'Tidak Aktif']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};

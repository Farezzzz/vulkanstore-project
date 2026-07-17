<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->increments('ID_Pesanan');
            $table->unsignedInteger('ID_Pengguna');
            $table->string('Nama_Pelanggan', 50);
            $table->string('Alamat', 100);
            $table->date('Tanggal');
            $table->integer('Total_Tagihan');
            $table->integer('Jarak_Tempuh_Km');
            $table->enum('Status_Pesanan', ['Diproses', 'Selesai', 'Dibatalkan']);
            $table->enum('Status_Pembayaran', ['Lunas', 'Belum Lunas']);

            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('pengguna')->onDelete('restrict');
        });

        DB::statement('ALTER TABLE pesanan MODIFY ID_Pesanan INT(4) UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE pesanan MODIFY ID_Pengguna INT(4) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE pesanan MODIFY Jarak_Tempuh_Km INT(3) NOT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};

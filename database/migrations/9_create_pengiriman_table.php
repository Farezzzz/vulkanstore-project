<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->increments('ID_Pengiriman'); 
            $table->unsignedInteger('ID_Pesanan'); 
            $table->date('Tanggal_Kirim');
            $table->enum('Status_Pengiriman', ['Disiapkan', 'Dikirim', 'Selesai']);

            $table->foreign('ID_Pesanan')->references('ID_Pesanan')->on('pesanan')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE pengiriman MODIFY ID_Pengiriman INT(4) UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE pengiriman MODIFY ID_Pesanan INT(4) UNSIGNED NOT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
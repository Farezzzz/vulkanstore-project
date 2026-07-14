<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->unsignedInteger('ID_Pesanan');
            $table->unsignedInteger('ID_Barang');
            $table->integer('Kuantitas'); 

            $table->primary(['ID_Pesanan', 'ID_Barang']);
            $table->foreign('ID_Pesanan')->references('ID_Pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('ID_Barang')->references('ID_Barang')->on('barang')->onDelete('restrict');
        });

        DB::statement('ALTER TABLE detail_pesanan MODIFY ID_Pesanan INT(4) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE detail_pesanan MODIFY ID_Barang INT(4) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE detail_pesanan MODIFY Kuantitas INT(5) NOT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
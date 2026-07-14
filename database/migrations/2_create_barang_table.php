<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('ID_Barang'); 
            $table->string('Nama_Barang', 50);
            $table->string('Kategori_Barang', 30);
            $table->integer('Stok_Tersedia');
            $table->integer('Harga_Jual'); 
            $table->timestamps();
            $table->softDeletes();
            });

        DB::statement('ALTER TABLE barang MODIFY ID_Barang INT(4) UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE barang MODIFY Stok_Tersedia INT(5) NOT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
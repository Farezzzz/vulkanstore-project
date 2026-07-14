<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_penerimaan', function (Blueprint $table) {
            $table->unsignedInteger('ID_Penerimaan');
            $table->unsignedInteger('ID_Barang'); 
            $table->integer('Kuantitas'); 
            $table->integer('Harga_Beli'); 

            $table->primary(['ID_Penerimaan', 'ID_Barang']);
            $table->foreign('ID_Penerimaan')->references('ID_Penerimaan')->on('penerimaan')->onDelete('cascade');
            $table->foreign('ID_Barang')->references('ID_Barang')->on('barang')->onDelete('restrict');
        });

        DB::statement('ALTER TABLE detail_penerimaan MODIFY ID_Penerimaan INT(4) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE detail_penerimaan MODIFY ID_Barang INT(4) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE detail_penerimaan MODIFY Kuantitas INT(5) NOT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penerimaan');
    }
};
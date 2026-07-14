<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerimaan', function (Blueprint $table) {
            $table->increments('ID_Penerimaan');
            $table->unsignedInteger('ID_Pemasok'); 
            $table->unsignedInteger('ID_Pengguna'); 
            $table->date('Tanggal_Masuk');
            $table->integer('Total_Biaya');

            $table->foreign('ID_Pemasok')->references('ID_Pemasok')->on('pemasok')->onDelete('restrict');
            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('pengguna')->onDelete('restrict');
        });

        DB::statement('ALTER TABLE penerimaan MODIFY ID_Penerimaan INT(4) UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE penerimaan MODIFY ID_Pemasok INT(4) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE penerimaan MODIFY ID_Pengguna INT(4) UNSIGNED NOT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('penerimaan');
    }
};
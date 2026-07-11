<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('barang', function (Blueprint $table) {
                $table->integer('ID_Barang', true);
                $table->string('Nama_Barang', 50);
                $table->string('Kategori_Barang', 30);
                $table->integer('Stok_Tersedia');
                $table->integer('Harga_Jual');
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('barang');
        }
    };

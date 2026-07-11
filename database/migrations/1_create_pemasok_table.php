<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('pemasok', function (Blueprint $table) {
                $table->integer('ID_Pemasok', true);
                $table->string('Nama_Pemasok', 50);
                $table->string('Kontak_Pemasok', 15);
                $table->enum('Kategori_Pemasok', ['INTERNAL', 'EXTERNAL (DIVISI VULKANISIR)']);
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('pemasok');
        }
    };

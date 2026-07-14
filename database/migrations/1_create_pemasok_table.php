<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('pemasok', function (Blueprint $table) {
                $table->increments('ID_Pemasok'); // PK
                $table->string('Nama_Pemasok', 50);
                $table->string('Kontak_Pemasok', 15);
                $table->enum('Kategori_Pemasok', ['INTERNAL (DIVISI VULKANISIR)', 'EXTERNAL']); 
                $table->timestamps();
            });

            DB::statement('ALTER TABLE pemasok MODIFY ID_Pemasok INT(4) UNSIGNED NOT NULL AUTO_INCREMENT');
        }

        public function down(): void
        {
            Schema::dropIfExists('pemasok');
        }
    };

<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('pengguna', function (Blueprint $table) {
                $table->increments('ID_Pengguna');
                $table->string('Nama_Lengkap', 50);
                $table->string('Role', 15);
                $table->string('Kata_Sandi', 255);
                $table->string('Email', 255)->unique();
                $table->enum('Status_Aktif', ['Aktif', 'Tidak Aktif'])->default('Aktif');
                $table->timestamps();
                $table->softDeletes();
            });

            DB::statement('ALTER TABLE pengguna MODIFY ID_Pengguna INT(4) UNSIGNED NOT NULL AUTO_INCREMENT');
        }

        public function down(): void
        {
            Schema::dropIfExists('pengguna');
        }
    };

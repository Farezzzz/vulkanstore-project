<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('pengguna', function (Blueprint $table) {
                $table->integer('ID_Pengguna', true);
                $table->string('Nama_Lengkap', 50);
                $table->string('Role', 15);
                $table->string('Kata_Sandi');
                $table->string('Email')->unique();
                $table->enum('Status_Aktif', ['Aktif', 'Tidak Aktif']);
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('pengguna');
        }
    };

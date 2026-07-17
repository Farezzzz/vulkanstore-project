<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->enum('Metode_Pengiriman', ['Diambil Sendiri', 'Dikirim'])->nullable()->after('Status_Pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn('Metode_Pengiriman');
        });
        }

};

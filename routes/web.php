<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PengirimanController;

Route::get('/', function () {
    return redirect()->route('pemasok.index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('pemasok', PemasokController::class);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('penerimaan', PenerimaanController::class);
    Route::resource('pesanan', PesananController::class); 
    Route::put('/pengiriman/{id}/update-status', [PengirimanController::class, 'updateStatus'])->name('pengiriman.updateStatus');
    Route::resource('pengiriman', PengirimanController::class); 
    
});

require __DIR__ . '/auth.php';

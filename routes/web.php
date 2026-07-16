<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenerimaanController;

Route::get('/', function () {
    return redirect()->route('pemasok.index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('pemasok', PemasokController::class);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('penerimaan', PenerimaanController::class);
});

require __DIR__ . '/auth.php';

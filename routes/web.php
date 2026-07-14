<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\BarangController; 
use App\Http\Controllers\PenggunaController;

Route::get('/', function () {
    return redirect()->route('pemasok.index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('pemasok', PemasokController::class);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('barang', BarangController::class); 
});

require __DIR__ . '/auth.php';
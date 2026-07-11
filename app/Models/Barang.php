<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'ID_Barang';
    public $incrementing = true;

    protected $fillable = [
        'Nama_Barang',
        'Kategori_Barang',
        'Stok_Tersedia',
        'Harga_Jual',
    ];
}

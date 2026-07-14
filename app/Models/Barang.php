<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use softDeletes;

    protected $table = 'barang';
    protected $primaryKey = 'ID_Barang';
    public $incrementing = true;

    protected $fillable = [
        'Nama_Barang',
        'Kategori_Barang',
        'Stok_Tersedia',
        'Harga_Jual',
    ];

    public function detailPenerimaan()
    {
        return $this->hasMany(DetailPenerimaan::class, 'ID_Barang', 'ID_Barang');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'ID_Barang', 'ID_Barang');
    }
}

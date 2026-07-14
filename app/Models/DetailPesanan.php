<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    
    public $incrementing = false; 
    public $timestamps = false;

    protected $fillable = [
        'ID_Pesanan', 
        'ID_Barang', 
        'Kuantitas'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'ID_Pesanan', 'ID_Pesanan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'ID_Barang', 'ID_Barang');
    }
}
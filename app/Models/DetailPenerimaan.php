<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenerimaan extends Model
{
    protected $table = 'detail_penerimaan';
    
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ID_Penerimaan', 
        'ID_Barang', 
        'Kuantitas', 
        'Harga_Beli'
    ];

    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan::class, 'ID_Penerimaan', 'ID_Penerimaan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'ID_Barang', 'ID_Barang');
    }
}
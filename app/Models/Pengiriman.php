<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';
    protected $primaryKey = 'ID_Pengiriman';
    
    public $timestamps = false;

    protected $fillable = [
        'ID_Pesanan', 
        'Tanggal_Kirim', 
        'Status_Pengiriman'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'ID_Pesanan', 'ID_Pesanan');
    }
}
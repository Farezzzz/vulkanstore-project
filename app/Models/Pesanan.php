<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'ID_Pesanan';
    public $timestamps = false;

    protected $fillable = [
        'ID_Pengguna',
        'Nama_Pelanggan',
        'Alamat',
        'Tanggal',
        'Total_Tagihan',
        'Jarak_Tempuh_Km',
        'Status_Pesanan',
        'Status_Pembayaran',
        'Metode_Pengiriman'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Pengguna', 'ID_Pengguna');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'ID_Pesanan', 'ID_Pesanan');
    }

    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'ID_Pesanan', 'ID_Pesanan');
    }
}

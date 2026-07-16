<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    use HasFactory;

    protected $table = 'penerimaan';
    protected $primaryKey = 'ID_Penerimaan';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'ID_Penerimaan',
        'ID_Pemasok',
        'ID_Pengguna',
        'Tanggal_Masuk',
        'Total_Biaya',
    ];
    protected $casts = [
        'Tanggal_Masuk' => 'date',
    ];


    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'ID_Pemasok', 'ID_Pemasok');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Pengguna', 'ID_Pengguna');
    }

    public function detailPenerimaan()
    {
        return $this->hasMany(DetailPenerimaan::class, 'ID_Penerimaan', 'ID_Penerimaan');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemasok extends Model
{
    use SoftDeletes;

    protected $table = 'pemasok';
    protected $primaryKey = 'ID_Pemasok';
    public $incrementing = true;

    protected $fillable = [
        'Nama_Pemasok',
        'Kontak_Pemasok',
        'Kategori_Pemasok',
    ];

    public function penerimaan()
    {
        return $this->hasMany(Penerimaan::class, 'ID_Pemasok', 'ID_Pemasok');
    }
}

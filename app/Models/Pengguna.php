<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengguna extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'pengguna';

    protected $primaryKey = 'ID_Pengguna';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Nama_Lengkap',
        'Role',
        'Kata_Sandi',
        'Email',
        'Status_Aktif',
    ];

    protected $hidden = [
        'Kata_Sandi',
    ];

    public function penerimaan()
    {
        return $this->hasMany(Penerimaan::class, 'ID_Pengguna', 'ID_Pengguna');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'ID_Pengguna', 'ID_Pengguna');
    }

    public function getAuthPassword()
    {
        return $this->Kata_Sandi;
    }
}

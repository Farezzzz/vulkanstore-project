<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

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

    public function getAuthPassword()
    {
        return $this->Kata_Sandi;
    }
}

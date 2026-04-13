<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // Tambahkan baris ini
    protected $fillable = [
        'nama',
        'angkatan',
        'tanggal_lahir',
        'no_wa',
        'no_ortu',
        'alamat_kos',
        'alamat_ortu'
    ];
}

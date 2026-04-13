<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Member extends Model
{
    protected $fillable = ['nama', 'angkatan', 'tanggal_lahir', 'no_ortu', 'no_wa', 'alamat_kos', 'alamat_ortu', 'is_aktif', 'is_jember', 'is_pengurus'];

    // Accessor untuk mengubah string "Jember, 4 Juni 1998" jadi objek tanggal
    public function getBirthDateAttribute()
    {
        try {
            $data = $this->tanggal_lahir;
            if (str_contains($data, ',')) {
                $data = trim(explode(',', $data)[1]);
            }
            $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $bulanEng  = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $cleanDate = str_ireplace($bulanIndo, $bulanEng, $data);
            return Carbon::parse($cleanDate);
        } catch (\Exception $e) { return null; }
    }

    public function isBirthdayToday()
    {
        return $this->birth_date ? $this->birth_date->isBirthday() : false;
    }
}

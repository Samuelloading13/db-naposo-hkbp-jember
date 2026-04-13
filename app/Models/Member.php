<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Member extends Model
{
public function getTanggalUltahAttribute()
{
    try {
        // Kita bersihkan string "Jember, 4 Juni 1998" secara otomatis
        $datePart = $this->tanggal_lahir;
        if (str_contains($datePart, ',')) {
            $datePart = trim(explode(',', $datePart)[1]);
        }

        // Mapping bulan Indonesia ke Inggris
        $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulanEng  = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $datePart = str_ireplace($bulanIndo, $bulanEng, $datePart);

        return Carbon::parse($datePart);
    } catch (\Exception $e) {
        return null;
    }
}

public function isBirthdayToday()
{
    try {
        $data = $this->tanggal_lahir;
        if (str_contains($data, ',')) {
            $data = trim(explode(',', $data)[1]);
        }

        // Ubah bulan Indo ke Inggris agar Carbon paham
        $bulan = ['Januari'=>'Jan','Februari'=>'Feb','Maret'=>'Mar','April'=>'Apr','Mei'=>'May','Juni'=>'Jun','Juli'=>'Jul','Agustus'=>'Aug','September'=>'Sep','Oktober'=>'Oct','November'=>'Nov','Desember'=>'Dec'];
        $cleanDate = str_ireplace(array_keys($bulan), array_values($bulan), $data);

        $birthDate = \Carbon\Carbon::parse($cleanDate);
        return $birthDate->isBirthday();
    } catch (\Exception $e) {
        return false;
    }
}
    // Tambahkan baris ini
    protected $fillable = ['nama', 'angkatan', 'tanggal_lahir', 'no_wa', 'no_ortu', 'alamat_kos', 'alamat_ortu'];
}

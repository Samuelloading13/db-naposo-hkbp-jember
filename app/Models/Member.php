<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Member extends Model
{
    protected $fillable = [
        'nama', 'angkatan', 'tanggal_lahir', 'no_ortu', 'no_wa',
        'alamat_kos', 'alamat_ortu', 'is_aktif', 'is_jember', 'is_pengurus'
    ];

    // Accessor: Membersihkan Tanggal Lahir (Handle "Jakarta, 8 Juni 2004")
    public function getFormattedBirthDateAttribute()
    {
        $data = $this->tanggal_lahir;
        if (empty($data)) return '-';
        try {
            if (str_contains($data, ',')) {
                $parts = explode(',', $data);
                $data = trim(end($parts));
            }
            $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $bulanEng  = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $cleanDate = str_ireplace($bulanIndo, $bulanEng, $data);
            return Carbon::parse($cleanDate)->translatedFormat('d F Y');
        } catch (\Exception $e) {
            return $this->tanggal_lahir;
        }
    }

    // Accessor: Fix WhatsApp (Otomatis +62)
    public function getWaUrlAttribute()
    {
        $nomor = preg_replace('/[^0-9]/', '', $this->no_wa);
        if (strpos($nomor, '0') === 0) {
            $nomor = '62' . substr($nomor, 1);
        } elseif (strpos($nomor, '8') === 0) {
            $nomor = '62' . $nomor;
        }
        return "https://api.whatsapp.com/send?phone=" . $nomor . "&text=Halo%20" . urlencode($this->nama);
    }

    public function isBirthdayToday()
    {
        try {
            $data = $this->tanggal_lahir;
            if (str_contains($data, ',')) { $data = trim(explode(',', $data)[1]); }
            $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $bulanEng  = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $cleanDate = str_ireplace($bulanIndo, $bulanEng, $data);
            return Carbon::parse($cleanDate)->isBirthday();
        } catch (\Exception $e) { return false; }
    }
}

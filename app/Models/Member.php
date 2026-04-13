<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Member extends Model
{
    protected $fillable = [
        'nama', 'angkatan', 'tanggal_lahir', 'no_ortu', 'no_wa',
        'alamat_kos', 'alamat_ortu', 'is_aktif', 'is_jember',
        'is_pengurus', 'jabatan_terakhir', 'periode_pengurus'
    ];

    // Accessor Link WhatsApp Otomatis
    public function getWaUrlAttribute()
    {
        $nomor = $this->no_wa ?? '';
        $nama = $this->nama ?? 'Anggota';
        if (empty($nomor)) return "#";
        $nomor = preg_replace('/[^0-9]/', '', $nomor);
        if (strpos($nomor, '0') === 0) {
            $nomor = '62' . substr($nomor, 1);
        } elseif (strpos($nomor, '8') === 0) {
            $nomor = '62' . $nomor;
        }
        return "https://api.whatsapp.com/send?phone=" . $nomor . "&text=Halo%20" . urlencode($nama);
    }

    // Cek Ulang Tahun
    public function isBirthdayToday()
    {
        try {
            $data = $this->tanggal_lahir ?? '';
            if (empty($data)) return false;
            if (str_contains($data, ',')) { $data = trim(explode(',', $data)[1]); }
            $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $bulanEng  = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $cleanDate = str_ireplace($bulanIndo, $bulanEng, $data);
            return Carbon::parse($cleanDate)->isBirthday();
        } catch (\Exception $e) { return false; }
    }
}

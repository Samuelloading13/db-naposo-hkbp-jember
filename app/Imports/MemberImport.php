<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Log;

class MemberImport implements ToModel
{
    public function model(array $row)
    {
        // 1. Skip jika baris kosong atau ini adalah baris header
        if (!isset($row[0]) || $row[0] == 'Nama') {
            return null;
        }

        // 2. Mapping kolom berdasarkan file "data naposo.xlsx" kamu:
        // [0] Nama, [1] Alamat Asal, [2] Angkatan, [3] Tgl Lahir, [4] No WA, [5] Status

        return new Member([
            'nama'          => $row[0],
            'angkatan'      => $row[2] ?? '2000', // Default jika kosong
            'tanggal_lahir' => $this->parseDate($row[3]), // Fungsi khusus di bawah
            'no_wa'         => $row[4] ?? '-',
            'no_ortu'       => '-', // Tidak ada di excel, kita isi strip dulu
            'alamat_kos'    => '-', // Tidak ada di excel, kita isi strip dulu
            'alamat_ortu'   => $row[1] ?? '-',
        ]);
    }

    private function parseDate($date)
    {
        if (empty($date)) return now()->format('Y-m-d');

        try {
            // Jika formatnya angka Excel (serial number)
            if (is_numeric($date)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            }

            // Jika format teks seperti 12/05/1998 atau 12-05-1998
            $cleanDate = str_replace('/', '-', $date);
            return Carbon::parse($cleanDate)->format('Y-m-d');

        } catch (\Exception $e) {
            // Jika gagal total, catat di log dan kasih tanggal default supaya tidak crash
            Log::error("Gagal parse tanggal: " . $date);
            return '2000-01-01';
        }
    }
}

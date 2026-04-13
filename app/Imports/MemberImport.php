<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings; // Tambahkan ini
use Carbon\Carbon;

class MemberImport implements ToModel, WithCustomCsvSettings
{
    // Fungsi untuk memberi tahu Laravel bahwa file ini pakai KOMA (,)
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function model(array $row)
{
    // Cek jika kolom nama (index 1) kosong, jangan diimport
    if (!isset($row[1]) || empty(trim($row[1]))) {
        return null;
    }

    // PAKAI ANGKA INDEX, BUKAN NAMA KOLOM
    return new Member([
        'nama'          => $row[1],           // Kolom B
        'angkatan'      => $row[2] ?? '-',    // Kolom C
        'tanggal_lahir' => $this->parseDate($row[3] ?? null), // Kolom D
        'no_ortu'       => $row[4] ?? '-',    // Kolom E
        'no_wa'         => $row[5] ?? '-',    // Kolom F
        'alamat_kos'    => $row[6] ?? '-',    // Kolom G
        'alamat_ortu'   => $row[7] ?? '-',    // Kolom H
    ]);
}

    private function parseDate($dateValue)
{
    if (!$dateValue) return null;
    try {
        // Bersihkan jika ada tempat lahir (Jember, 4 Juni 1998)
        if (str_contains($dateValue, ',')) {
            $parts = explode(',', $dateValue);
            $dateValue = trim(end($parts));
        }

        $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulanEng  = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $dateValue = str_ireplace($bulanIndo, $bulanEng, $dateValue);

        return \Carbon\Carbon::parse($dateValue)->format('Y-m-d');
    } catch (\Exception $e) {
        return null;
    }
}
}

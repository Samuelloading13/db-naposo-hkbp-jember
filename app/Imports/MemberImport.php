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
    // Skip baris header jika kolom pertama isinya tulisan "Nama"
    if (!isset($row[0]) || $row[0] == 'Nama' || empty($row[0])) {
        return null;
    }

    return new Member([
        'nama'          => $row[0],
        'alamat_ortu'   => $row[1] ?? '-', // Alamat Asal
        'angkatan'      => $row[2] ?? '2000',
        'tanggal_lahir' => $this->parseDate($row[3]), // Kolom ke-4 adalah Tanggal
        'no_wa'         => $row[4] ?? '-',
        'no_ortu'       => '-',
        'alamat_kos'    => '-',
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

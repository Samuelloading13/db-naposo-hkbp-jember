<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;


class MemberController extends Controller
{
    /**
     * Tampilkan Daftar Database & Notif Ultah
     */
    public function index(Request $request) {
    $query = Member::query();

        // 1. Fitur Search & Filter
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->angkatan) {
            $query->where('angkatan', $request->angkatan);
        }
        if ($request->domisili == 'jember') {
            $query->where('is_jember', 1);
        }

        // 2. Pagination (Biar web pendek, tampilkan 10 data per halaman)
        $members = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        // 3. Statistik Dashboard
        $stats = [
            'total' => Member::count(),
            'aktif' => Member::where('is_aktif', 1)->count(),
            'jember' => Member::where('is_jember', 1)->count(),
            'ultah_count' => Member::all()->filter->isBirthdayToday()->count()
        ];

        // 4. Data untuk Notif
        $whoIsBirthday = Member::all()->filter->isBirthdayToday();
        $listAngkatan = Member::select('angkatan')->distinct()->orderBy('angkatan', 'desc')->get();

        return view('members.index', compact('members', 'stats', 'listAngkatan', 'whoIsBirthday'));
    }

    public function show(Member $member) {
        return view('members.show', compact('member'));
    }

    public function create()
    {
    return view('members.create');
    }

    public function edit(Member $member) {
        return view('members.edit', compact('member'));
    }

   public function update(Request $request, Member $member) {
    // Validasi dasar
    $data = $request->validate([
        'nama' => 'required',
        'is_aktif' => 'required',
        'is_jember' => 'required',
        'is_pengurus' => 'required',
        'jabatan_terakhir' => 'nullable|string',
        'periode_pengurus' => 'nullable|string',
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Data ' . $member->nama . ' berhasil diupdate!');
    }

    public function destroy(Member $member) {
        $member->delete();
        return back()->with('success', 'Anggota dihapus!');
    }

    public function getWaUrlAttribute()
{
    // 1. Ambil nomor asli dari database
    $nomor = $this->no_wa;

    // 2. Hapus semua karakter selain angka (spasi, tanda plus, minus, dll)
    $nomor = preg_replace('/[^0-9]/', '', $nomor);

    // 3. Cek jika nomor diawali angka '0' (misal: 0812...)
    if (strpos($nomor, '0') === 0) {
        $nomor = '62' . substr($nomor, 1);
    }
    // 4. Cek jika nomor sudah diawali '8' (misal: 812...) tapi belum ada 62
    elseif (strpos($nomor, '8') === 0) {
        $nomor = '62' . $nomor;
    }

    // 5. Kembalikan link lengkap WhatsApp API
    return "https://api.whatsapp.com/send?phone=" . $nomor . "&text=Halo%20" . urlencode($this->nama);
}
    public function export()
{
    $members = \App\Models\Member::all();
    $filename = "data_naposo_jember_" . date('Y-m-d') . ".csv";

    // Headers agar browser mengenali ini sebagai file download CSV
    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $callback = function() use($members) {
        $file = fopen('php://output', 'w');

        // Judul Kolom di Excel
        fputcsv($file, ['ID', 'Nama', 'Angkatan', 'WA', 'Status', 'Domisili', 'Jabatan', 'Periode']);

        foreach ($members as $m) {
            fputcsv($file, [
                $m->id,
                $m->nama,
                $m->angkatan,
                $m->no_wa,
                $m->is_aktif ? 'Aktif' : 'Pasif',
                $m->is_jember ? 'Asli Jember' : 'Luar Jember',
                $m->jabatan_terakhir ?? '-',
                $m->periode_pengurus ?? '-'
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}

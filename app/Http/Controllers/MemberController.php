<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request) {
        $query = Member::query();

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->angkatan) {
            $query->where('angkatan', $request->angkatan);
        }
        if ($request->domisili == 'jember') {
            $query->where('is_jember', 1);
        }

        $members = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        $stats = [
            'total' => Member::count(),
            'aktif' => Member::where('is_aktif', 1)->count(),
            'jember' => Member::where('is_jember', 1)->count(),
            'ultah_count' => Member::all()->filter->isBirthdayToday()->count()
        ];

        $whoIsBirthday = Member::all()->filter->isBirthdayToday();
        $listAngkatan = Member::select('angkatan')->distinct()->orderBy('angkatan', 'desc')->get();

        return view('members.index', compact('members', 'stats', 'listAngkatan', 'whoIsBirthday'));
    }

    public function show(Member $member) {
        return view('members.show', compact('member'));
    }

    public function create() {
        return view('members.create');
    }

    public function edit(Member $member) {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member) {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'angkatan' => 'required|integer',
            'tanggal_lahir' => 'nullable|string',
            'no_wa' => 'nullable|string',
            'no_ortu' => 'nullable|string',
            'alamat_kos' => 'nullable|string',
            'alamat_ortu' => 'nullable|string',
            'is_aktif' => 'required|boolean',
            'is_jember' => 'required|boolean',
            'is_pengurus' => 'required|boolean',
            'jabatan_terakhir' => 'nullable|string',
            'periode_pengurus' => 'nullable|string',
        ]);

        $member->update($data);
        return redirect()->route('members.show', $member->id)->with('success', 'Profil berhasil diperbarui!');
    }

    public function destroy(Member $member) {
        $nama = $member->nama;
        $member->delete();
        return redirect()->route('members.index')->with('success', "Data $nama telah dihapus.");
    }

    public function export() {
        $members = Member::all();
        $filename = "data_naposo_jember_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use($members) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama', 'Angkatan', 'WA', 'Status', 'Domisili', 'Jabatan', 'Periode']);
            foreach ($members as $m) {
                fputcsv($file, [
                    $m->id, $m->nama, $m->angkatan, $m->no_wa,
                    $m->is_aktif ? 'Aktif' : 'Pasif',
                    $m->is_jember ? 'Asli Jember' : 'Luar Jember',
                    $m->jabatan_terakhir ?? '-', $m->periode_pengurus ?? '-'
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}

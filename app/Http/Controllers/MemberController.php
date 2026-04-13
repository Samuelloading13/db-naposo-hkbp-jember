<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Imports\MemberImport; // <--- TAMBAHKAN BARIS INI
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class MemberController extends Controller
{
    /**
     * Tampilkan Daftar Database & Notif Ultah
     */
    public function index(Request $request) {
    $query = Member::query();

    // Fitur Filter
    if ($request->angkatan) $query->where('angkatan', $request->angkatan);
    if ($request->status == 'aktif') $query->where('is_aktif', 1);

    // Fitur Urutan (Sorting)
    $sort = $request->get('sort', 'nama'); // Default urut nama
    $direction = $request->get('direction', 'asc');
    $query->orderBy($sort, $direction);

    $members = $query->get();

    // Data Statistik Dashboard
    $stats = [
        'total' => Member::count(),
        'aktif' => Member::where('is_aktif', 1)->count(),
        'jember' => Member::where('is_jember', 1)->count(),
        // Fitur Ultah Terdeteksi di Sini
        'ultah' => Member::all()->filter->isBirthdayToday()->count()
    ];

    $listAngkatan = Member::select('angkatan')->distinct()->orderBy('angkatan', 'desc')->get();

    return view('members.index', compact('members', 'stats', 'listAngkatan'));
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
        $member->update($request->all()); // Simpel untuk update kategori & data
        return redirect()->route('members.index')->with('success', 'Data diperbarui!');
    }

    public function destroy(Member $member) {
        $member->delete();
        return back()->with('success', 'Anggota dihapus!');
    }
}

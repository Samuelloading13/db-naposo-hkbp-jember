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
    public function index()
{
    $members = Member::all();
    $today = Carbon::now()->format('m-d');

    // Ambil anggota yang bulan dan harinya sama dengan hari ini
    $ultahHariIni = Member::whereRaw("DATE_FORMAT(tanggal_lahir, '%m-%d') = ?", [$today])->get();

    return view('members.index', compact('members', 'ultahHariIni'));
}

    /**
     * Fitur Rincian
     */
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('members.show', compact('member'));
    }

    /**
     * Fitur Tambah Data (Create)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'angkatan' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_wa' => 'required',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')->with('success', 'Data Anggota berhasil ditambahkan!');
    }

    /**
     * Fitur Edit Data (Update)
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Fitur Hapus Data (Delete)
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Fitur Import dari Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MemberImport, $request->file('file_excel'));
            return redirect()->route('members.index')->with('success', 'Data Excel berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('members.index')->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}

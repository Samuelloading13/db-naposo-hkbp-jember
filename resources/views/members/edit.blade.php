@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5 px-3">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-4 border-0">
            <h5 class="fw-bold mb-0 text-primary">Edit Profil: {{ $member->nama }}</h5>
        </div>
        <div class="card-body p-4 pt-0">
            <form action="{{ route('members.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control rounded-3" value="{{ $member->nama }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Angkatan</label>
                        <input type="number" name="angkatan" class="form-control rounded-3" value="{{ $member->angkatan }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Tanggal Lahir</label>
                        <input type="text" name="tanggal_lahir" class="form-control rounded-3" value="{{ $member->tanggal_lahir }}" placeholder="Contoh: Jember, 12 Januari 2001">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">No. WA (Member)</label>
                        <input type="text" name="no_wa" class="form-control rounded-3" value="{{ $member->no_wa }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">No. WA (Orang Tua)</label>
                        <input type="text" name="no_ortu" class="form-control rounded-3" value="{{ $member->no_ortu }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Alamat di Jember (Kos/Rumah)</label>
                    <textarea name="alamat_kos" class="form-control rounded-3" rows="2">{{ $member->alamat_kos }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Alamat Asal (Orang Tua)</label>
                    <textarea name="alamat_ortu" class="form-control rounded-3" rows="2">{{ $member->alamat_ortu }}</textarea>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Status Keanggotaan</label>
                        <select name="is_aktif" class="form-select rounded-3">
                            <option value="1" {{ $member->is_aktif ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$member->is_aktif ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Asli Jember?</label>
                        <select name="is_jember" class="form-select rounded-3">
                            <option value="1" {{ $member->is_jember ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ !$member->is_jember ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4 p-3 rounded-4 bg-light border">
                    <label class="form-label small fw-bold text-primary">Status Kepengurusan</label>
                    <select name="is_pengurus" id="is_pengurus" class="form-select rounded-3 mb-3" onchange="togglePengurus()">
                        <option value="0" {{ !$member->is_pengurus ? 'selected' : '' }}>Bukan Pengurus</option>
                        <option value="1" {{ $member->is_pengurus ? 'selected' : '' }}>Pernah/Sedang Pengurus</option>
                    </select>

                    <div id="boxJabatan" style="display: {{ $member->is_pengurus ? 'block' : 'none' }}">
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="small text-muted">Jabatan Terakhir</label>
                                <input type="text" name="jabatan_terakhir" class="form-control rounded-3" value="{{ $member->jabatan_terakhir }}" placeholder="Misal: Ketua">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted">Periode</label>
                                <input type="text" name="periode_pengurus" class="form-control rounded-3" value="{{ $member->periode_pengurus }}" placeholder="2024-2026">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary fw-bold rounded-pill shadow-sm" style="background-color: #003366;">Simpan Perubahan</button>
                    <a href="{{ route('members.index') }}" class="btn btn-light rounded-pill">Batal</a>
                </div>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <p class="text-muted small mb-2">Hapus data permanen?</p>
                <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $member->nama }}? Data yang dihapus tidak bisa dikembalikan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4">
                        <i class="fas fa-trash-alt me-2"></i>Hapus Anggota
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePengurus() {
    var status = document.getElementById("is_pengurus").value;
    document.getElementById("boxJabatan").style.display = (status == "1") ? "block" : "none";
}
</script>
@endsection

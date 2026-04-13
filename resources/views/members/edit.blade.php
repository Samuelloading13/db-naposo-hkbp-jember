@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white fw-bold">Edit Data: {{ $member->nama }}</div>
                <div class="card-body">
                    <form action="{{ route('members.update', $member->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $member->nama }}">
                            </div>
                            <div class="col-md-6">
                                <label>No WhatsApp</label>
                                <input type="text" name="no_wa" class="form-control" value="{{ $member->no_wa }}">
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded mb-3">
                            <label class="d-block mb-2 fw-bold text-primary">Kategori Anggota</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_aktif" value="0">
                                <input class="form-check-input" type="checkbox" name="is_aktif" value="1" {{ $member->is_aktif ? 'checked' : '' }}>
                                <label class="form-check-label">Anggota Aktif</label>
                            </div>
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_jember" value="0">
                                <input class="form-check-input" type="checkbox" name="is_jember" value="1" {{ $member->is_jember ? 'checked' : '' }}>
                                <label class="form-check-label">Domisili Asli Jember</label>
                            </div>
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_pengurus" value="0">
                                <input class="form-check-input" type="checkbox" name="is_pengurus" value="1" {{ $member->is_pengurus ? 'checked' : '' }}>
                                <label class="form-check-label">Pernah Jadi Pengurus</label>
                            </div>
                        </div>
                        <div class="mt-4 p-3 rounded-4 border" style="background-color: #f8f9fa;">
                        <label class="d-block mb-3 fw-bold text-primary">
                            <i class="fas fa-user-shield me-2"></i>Status Kepengurusan
                        </label>

                        <div class="form-check form-switch mb-3">
                            <input type="hidden" name="is_pengurus" value="0">
                            <input class="form-check-input" type="checkbox" id="checkPengurus" name="is_pengurus" value="1" {{ $member->is_pengurus ? 'checked' : '' }} onchange="togglePengurus()">
                            <label class="form-check-label" for="checkPengurus">Pernah Jadi Pengurus?</label>
                        </div>

                        <div id="formJabatan" style="display: {{ $member->is_pengurus ? 'block' : 'none' }}">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="small text-muted">Jabatan Terakhir</label>
                                    <input type="text" name="jabatan_terakhir" class="form-control form-control-sm" value="{{ $member->jabatan_terakhir }}" placeholder="Contoh: Ketua, Sekretaris, dll">
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted">Periode (Tahun)</label>
                                    <input type="text" name="periode_pengurus" class="form-control form-control-sm" value="{{ $member->periode_pengurus }}" placeholder="Contoh: 2024-2026">
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function togglePengurus() {
                            var checkBox = document.getElementById("checkPengurus");
                            var textForm = document.getElementById("formJabatan");
                            if (checkBox.checked == true){
                                textForm.style.display = "block";
                            } else {
                                textForm.style.display = "none";
                            }
                        }
                    </script>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('members.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

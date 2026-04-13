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

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('members.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

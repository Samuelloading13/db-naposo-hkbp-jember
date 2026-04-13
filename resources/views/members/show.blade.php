@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-4 border-0">
            <h4 class="fw-bold text-primary mb-0">{{ $member->nama }}</h4>
            <span class="badge bg-light text-dark">Angkatan {{ $member->angkatan }}</span>
        </div>
        <div class="card-body p-4 pt-0">
            <div class="row g-4">
                <div class="col-md-6 border-end">
                    <h6 class="text-muted small mb-1">Tanggal Lahir</h6>
                    <p class="fw-bold">{{ $member->formatted_birth_date }}</p>

                    <h6 class="text-muted small mb-1 mt-3">Nomor WhatsApp</h6>
                    <p class="fw-bold">{{ $member->no_wa }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted small mb-1">Alamat di Jember</h6>
                    <p class="fw-bold">{{ $member->alamat_kos ?? '-' }}</p>
                </div>
            </div>
            <hr>
            <a href="{{ $member->wa_url }}" target="_blank" class="btn btn-success w-100 fw-bold rounded-pill">
                <i class="fab fa-whatsapp me-2"></i> Hubungi Sekarang
            </a>
            <a href="{{ route('members.index') }}" class="btn btn-light w-100 mt-2 rounded-pill">Kembali</a>
        </div>
        <div class="mt-4 p-3 rounded-4" style="background-color: #f0f7ff; border-left: 5px solid #003366;">
            <h6 class="fw-bold text-primary"><i class="fas fa-history me-2"></i>Histori Kepengurusan</h6>
            @if($member->is_pengurus)
                <p class="mb-1"><strong>Jabatan:</strong> {{ $member->jabatan_terakhir ?? 'Anggota Pengurus' }}</p>
                <p class="mb-0 text-muted small"><strong>Periode:</strong> {{ $member->periode_pengurus ?? '-' }}</p>
            @else
                <p class="text-muted mb-0 small italic">Belum pernah menjadi pengurus.</p>
            @endif
        </div>
    </div>
</div>
@endsection

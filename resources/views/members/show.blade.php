@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5 px-3">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-primary mb-0">{{ $member->nama }}</h4>
                <span class="badge bg-light text-dark">Angkatan {{ $member->angkatan }}</span>
            </div>
            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-light btn-sm rounded-circle"><i class="fa fa-edit text-warning"></i></a>
        </div>

        <div class="card-body p-4 pt-0">
            <div class="row g-4">
                <div class="col-md-6 border-end">
                    <h6 class="text-muted small mb-1"><i class="fas fa-birthday-cake me-2"></i>Tanggal Lahir</h6>
                    <p class="fw-bold">{{ $member->formatted_birth_date }}</p>

                    <h6 class="text-muted small mb-1 mt-3"><i class="fab fa-whatsapp me-2"></i>Nomor WhatsApp</h6>
                    <p class="fw-bold">{{ $member->no_wa }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted small mb-1"><i class="fas fa-map-marker-alt me-2"></i>Alamat di Jember</h6>
                    <p class="fw-bold">{{ $member->alamat_kos ?? '-' }}</p>

                    <h6 class="text-muted small mb-1 mt-3"><i class="fas fa-home me-2"></i>Alamat Orang Tua</h6>
                    <p class="fw-bold">{{ $member->alamat_ortu ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-4 p-3 rounded-4" style="background-color: #f8faff; border: 1px solid #dee2e6;">
                <h6 class="fw-bold mb-3" style="color: #003366;"><i class="fas fa-award me-2"></i>Status Kepengurusan</h6>
                @if($member->is_pengurus)
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $member->jabatan_terakhir ?? 'Pengurus' }}</h6>
                            <small class="text-muted">Periode: {{ $member->periode_pengurus ?? '-' }}</small>
                        </div>
                    </div>
                @else
                    <p class="text-muted small mb-0 italic text-center py-2">Bukan merupakan pengurus.</p>
                @endif
            </div>

            <div class="mt-4 d-grid gap-2">
                <a href="{{ $member->wa_url }}" target="_blank" class="btn btn-success fw-bold rounded-pill">
                    <i class="fab fa-whatsapp me-2"></i> Hubungi via WhatsApp
                </a>
                <a href="{{ route('members.index') }}" class="btn btn-light rounded-pill">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<nav class="navbar navbar-dark sticky-top shadow" style="background-color: #003366; padding: 12px 0;">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('images/logo_hkbp.png') }}" width="48" class="me-3" alt="Logo HKBP">
            <img src="{{ asset('images/logo_nhkbp.png') }}" width="45" height="45" class="me-3 rounded-circle border border-white border-2 shadow-sm" style="background-color: white; object-fit: cover;">
            <div class="lh-1">
                <span class="fw-bold d-block" style="font-size: 16px; letter-spacing: 0.5px;">DATABASE</span>
                <span class="fw-bold" style="font-size: 13px; color: #ffc107;">NHKBP JEMBER</span>
            </div>
        </a>
        <form action="{{ route('logout') }}" method="POST">@csrf
            <button class="btn btn-sm btn-outline-light border-0"><i class="fa fa-sign-out-alt fa-lg"></i></button>
        </form>
    </div>
</nav>

<div class="container mt-3 px-3">
    <div class="row g-2 mb-4 flex-nowrap overflow-auto pb-2">
        <div class="col-7 col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white p-3 rounded-4">
                <small style="font-size: 11px; opacity: 0.8;">Total Naposo</small>
                <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
            </div>
        </div>
        <div class="col-7 col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white p-3 rounded-4">
                <small style="font-size: 11px; opacity: 0.8;">Aktif</small>
                <h3 class="fw-bold mb-0">{{ $stats['aktif'] }}</h3>
            </div>
        </div>
        <div class="col-7 col-md-3">
            <div class="card border-0 shadow-sm bg-danger text-white p-3 rounded-4">
                <small style="font-size: 11px; opacity: 0.8;">Ultah Hari Ini 🎂</small>
                <h3 class="fw-bold mb-0">{{ $stats['ultah_count'] }}</h3>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3 rounded-4">
        <div class="card-body p-3">
            <form action="{{ route('members.index') }}" method="GET" class="row g-2">
                <div class="col-12 col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm rounded-3" placeholder="Cari nama..." value="{{ request('search') }}">
                </div>
                <div class="col-6 col-md-3">
                    <select name="angkatan" class="form-select form-select-sm rounded-3">
                        <option value="">Semua Angkatan</option>
                        @foreach($listAngkatan as $a)
                        <option value="{{ $a->angkatan }}" {{ request('angkatan') == $a->angkatan ? 'selected' : '' }}>{{ $a->angkatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <select name="domisili" class="form-select form-select-sm rounded-3">
                        <option value="">Semua Lokasi</option>
                        <option value="jember" {{ request('domisili') == 'jember' ? 'selected' : '' }}>📍 Domisili Jember</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 d-flex gap-1">
                    <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3 fw-bold">Filter</button>
                    @if(request()->anyFilled(['search', 'angkatan', 'domisili']))
                        <a href="{{ route('members.index') }}" class="btn btn-light btn-sm border rounded-3"><i class="fa fa-sync"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-4 overflow-hidden mb-3">
        @forelse($members as $m)
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
            <div onclick="window.location='{{ route('members.show', $m->id) }}'" style="cursor:pointer">
                <h6 class="fw-bold mb-1" style="font-size: 14px;">{{ $m->nama }} @if($m->isBirthdayToday()) 🎂 @endif</h6>
                <small class="text-muted">
                    {{ $m->angkatan }} •
                    @if($m->is_jember) <span class="text-primary fw-bold">Jember</span> @else Luar Jember @endif
                </small>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('members.edit', $m->id) }}" class="text-warning"><i class="fa fa-edit fa-lg"></i></a>
                <a href="{{ $m->wa_url }}" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm fw-bold" style="font-size: 11px;">
                    <i class="fab fa-whatsapp me-1"></i> WA
                </a>
            </div>
        </div>
        @empty
        <div class="p-5 text-center text-muted small">Data tidak ditemukan.</div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mb-5">
        {{ $members->links('pagination::bootstrap-5') }}
    </div>
</div>

<footer class="mt-5 pb-5 text-center">
    <hr class="mx-auto w-25">
    <div class="p-3">
        <h6 class="fw-bold mb-1" style="color: #003366;">Database NHKBP JEMBER v1.1</h6>
        <p class="text-muted small">Developed by <strong>Naposo HKBP Jember</strong></p>
        <div class="d-flex justify-content-center gap-2 mt-2">
            <a href="{{ route('members.export') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 text-decoration-none shadow-sm"><i class="fas fa-file-export me-1"></i> Export</a>
            <a href="{{ route('members.create') }}" class="btn btn-sm btn-dark rounded-pill px-3 text-decoration-none shadow-sm"><i class="fas fa-plus me-1"></i> Tambah</a>
        </div>
    </div>
</footer>
@endsection

@extends('layouts.app')

@section('content')
<style>
    /* Styling agar Pagination rapi */
    .pagination { font-size: 0.85rem; }
    .page-link { color: #003366; border-radius: 8px !important; margin: 0 2px; }
    .page-item.active .page-link { background-color: #003366; border-color: #003366; }
</style>

<nav class="navbar navbar-dark sticky-top shadow-sm" style="background-color: #003366;">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="https://upload.wikimedia.org/wikipedia/id/f/f3/Logo_HKBP.png" width="35" class="me-2">
            <span class="fw-bold" style="font-size: 16px;">NHKBP JEMBER</span>
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-outline-light border-0"><i class="fa fa-sign-out-alt"></i></button>
        </form>
    </div>
</nav>

<div class="container mt-3 px-3">
    <div class="row g-2 mb-4 flex-nowrap overflow-auto pb-2" style="-webkit-overflow-scrolling: touch;">
        <div class="col-7 col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white p-3 rounded-4">
                <small style="font-size: 11px;">Total Naposo</small>
                <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
            </div>
        </div>
        <div class="col-7 col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white p-3 rounded-4">
                <small style="font-size: 11px;">Aktif</small>
                <h4 class="fw-bold mb-0">{{ $stats['aktif'] }}</h4>
            </div>
        </div>
        <div class="col-7 col-md-3">
            <div class="card border-0 shadow-sm bg-info text-white p-3 rounded-4">
                <small style="font-size: 11px;">Asli Jember</small>
                <h4 class="fw-bold mb-0">{{ $stats['jember'] }}</h4>
            </div>
        </div>
        <div class="col-7 col-md-3">
            <div class="card border-0 shadow-sm bg-danger text-white p-3 rounded-4">
                <small style="font-size: 11px;">Ultah Hari Ini 🎂</small>
                <h4 class="fw-bold mb-0">{{ $stats['ultah_count'] }}</h4>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3 rounded-4">
        <div class="card-body p-3">
            <form action="{{ route('members.index') }}" method="GET" class="row g-2">
                <div class="col-12 col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm rounded-3" placeholder="Cari nama..." value="{{ request('search') }}">
                </div>
                <div class="col-6 col-md-2">
                    <select name="angkatan" class="form-select form-select-sm rounded-3">
                        <option value="">Angkatan</option>
                        @foreach($listAngkatan as $a)
                        <option value="{{ $a->angkatan }}" {{ request('angkatan') == $a->angkatan ? 'selected' : '' }}>{{ $a->angkatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="domisili" class="form-select form-select-sm rounded-3">
                        <option value="">Domisili</option>
                        <option value="jember" {{ request('domisili') == 'jember' ? 'selected' : '' }}>Asli Jember</option>
                    </select>
                </div>
                <div class="col-12 col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3">Filter</button>
                    @if(request()->anyFilled(['search', 'angkatan', 'domisili']))
                        <a href="{{ route('members.index') }}" class="btn btn-light btn-sm rounded-3 border">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="list-group shadow-sm rounded-4 overflow-hidden mb-3">
        @forelse($members as $m)
        <div class="list-group-item list-group-item-action border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div onclick="window.location='{{ route('members.show', $m->id) }}'" style="cursor:pointer">
                    <h6 class="fw-bold mb-0" style="font-size: 14px;">{{ $m->nama }} @if($m->isBirthdayToday()) 🎂 @endif</h6>
                    <small class="text-muted" style="font-size: 12px;">{{ $m->angkatan }} • {{ $m->is_aktif ? 'Aktif' : 'Pasif' }}</small>
                </div>
                <div class="d-flex gap-1">
                    <a href="{{ route('members.edit', $m->id) }}" class="btn btn-light btn-sm rounded-circle shadow-sm">
                        <i class="fa fa-edit text-warning"></i>
                    </a>
                    <a href="{{ $m->wa_url }}" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" style="font-size: 12px;">
                        <i class="fab fa-whatsapp"></i> Chat
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="list-group-item text-center py-5">
            <p class="text-muted mb-0">Anggota tidak ditemukan.</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mb-5">
        {{ $members->links('pagination::bootstrap-5') }}
    </div>
</div>

@if($whoIsBirthday->count() > 0)
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1060">
    <div id="igNotif" class="card border-0 shadow-lg animate__animated animate__fadeInUp rounded-4" style="width: 280px; overflow: hidden;">
        <div class="card-header border-0 text-white py-2" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
            <span class="fw-bold small"><i class="fa fa-birthday-cake me-1"></i> Birthday Alert!</span>
            <button type="button" class="btn-close btn-close-white float-end" onclick="document.getElementById('igNotif').remove()" style="font-size: 10px;"></button>
        </div>
        <div class="card-body p-3 bg-white">
            @foreach($whoIsBirthday as $bday)
            <div class="d-flex align-items-center mb-2">
                <div class="bg-light rounded-circle text-center me-2" style="width: 30px; height: 30px; line-height: 30px; font-size: 14px;">🎂</div>
                <div class="flex-grow-1">
                    <small class="fw-bold d-block" style="font-size: 11px;">{{ $bday->nama }}</small>
                </div>
                <a href="{{ $bday->wa_url }}" target="_blank" class="btn btn-success btn-sm py-0 px-2" style="font-size: 10px;">Chat</a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<footer class="mt-5 pb-5 text-center">
    <hr class="mx-auto w-25">
    <div class="p-3">
        <h6 class="fw-bold mb-1" style="color: #003366;">Database NHKBP JEMBER v1.0</h6>
        <p class="text-muted small">
            Dikembangkan oleh <strong>Naposo HKBP Jember</strong> <br>
            &copy; 2026 NHKBP Jember. All rights reserved.
        </p>
        <div class="d-flex justify-content-center gap-2 mt-2">
            <a href="{{ route('members.export') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 shadow-sm">
                <i class="fas fa-file-export me-1"></i> Export Data
            </a>
            <a href="{{ route('members.create') }}" class="btn btn-sm btn-dark rounded-pill px-3 shadow-sm">
                <i class="fas fa-plus me-1"></i> Tambah
            </a>
        </div>
    </div>
</footer>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection

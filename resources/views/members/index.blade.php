@extends('layouts.app')

@section('content')
<nav class="navbar navbar-dark sticky-top shadow-sm" style="background-color: #003366;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="https://upload.wikimedia.org/wikipedia/id/f/f3/Logo_HKBP.png" width="35" class="me-2">
            <span class="fw-bold" style="font-size: 16px;">NHKBP JEMBER</span>
        </a>
        <form action="{{ route('logout') }}" method="POST">@csrf <button class="btn btn-sm btn-outline-light border-0"><i class="fa fa-sign-out"></i></button></form>
    </div>
</nav>

<div class="container mt-3 mb-5">
    <div class="row g-2 mb-4 flex-nowrap overflow-auto pb-2" style="-webkit-overflow-scrolling: touch;">
        <div class="col-8 col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white p-3">
                <small>Total Naposo</small>
                <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
            </div>
        </div>
        <div class="col-8 col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white p-3">
                <small>Aktif</small>
                <h4 class="fw-bold mb-0">{{ $stats['aktif'] }}</h4>
            </div>
        </div>
        <div class="col-8 col-md-3">
            <div class="card border-0 shadow-sm bg-danger text-white p-3">
                <small>Ultah Hari Ini 🎂</small>
                <h4 class="fw-bold mb-0">{{ $stats['ultah'] }}</h4>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form action="{{ route('members.index') }}" method="GET" class="row g-2">
                <div class="col-6 col-md-4">
                    <select name="angkatan" class="form-select form-select-sm">
                        <option value="">Semua Angkatan</option>
                        @foreach($listAngkatan as $a)
                        <option value="{{ $a->angkatan }}" {{ request('angkatan') == $a->angkatan ? 'selected' : '' }}>{{ $a->angkatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-4">
                    <select name="sort" class="form-select form-select-sm">
                        <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Urut Nama (A-Z)</option>
                        <option value="angkatan" {{ request('sort') == 'angkatan' ? 'selected' : '' }}>Urut Angkatan</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-block d-md-none">
        @foreach($members as $m)
        <div class="card border-0 shadow-sm mb-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-0">{{ $m->nama }} @if($m->isBirthdayToday()) 🎂 @endif</h6>
                    <small class="text-muted">Angkatan {{ $m->angkatan }}</small>
                </div>
                @php
                    // PERBAIKAN WA: Hapus karakter non-angka dan pastikan format 62
                    $phone = preg_replace('/[^0-9]/', '', $m->no_wa);
                    if(strpos($phone, '0') === 0) { $phone = '62' . substr($phone, 1); }
                @endphp
                <a href="https://api.whatsapp.com/send?phone={{ $phone }}&text=Halo%20{{ $m->nama }}" class="btn btn-success btn-sm rounded-circle"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-none d-md-block card border-0 shadow-sm rounded-3">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $m)
                <tr>
                    <td>{{ $m->nama }} @if($m->isBirthdayToday()) 🎂 @endif</td>
                    <td>{{ $m->angkatan }}</td>
                    <td>
                        <a href="{{ route('members.show', $m->id) }}" class="btn btn-sm btn-light"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('members.edit', $m->id) }}" class="btn btn-sm btn-light"><i class="fa fa-edit"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

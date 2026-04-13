<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Naposo HKBP Jember</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: #2c3e50; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .btn-wa { background-color: #25D366; color: white; }
        .btn-wa:hover { background-color: #128C7E; color: white; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1"><i class="fas fa-church me-2"></i> Naposo HKBP Jember</span>
    </div>
</nav>

<div class="container">
    @if($ultahHariIni->count() > 0)
    <div class="alert alert-warning border-0 shadow-sm alert-dismissible fade show" role="alert">
        <h5 class="alert-heading"><i class="fas fa-birthday-cake me-2"></i> Ulang Tahun Hari Ini!</h5>
        <hr>
        @foreach($ultahHariIni as $u)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span><strong>{{ $u->nama }}</strong> ({{ $u->angkatan }})</span>
                <a href="https://wa.me/{{ $u->no_wa }}" target="_blank" class="btn btn-sm btn-wa">
                    <i class="fab fa-whatsapp"></i> Ucapkan Selamat
                </a>
            </div>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card p-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-secondary fw-bold">Daftar Anggota</h4>
            <div>
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalImport"><i class="fas fa-file-excel me-1"></i> Import Excel</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fas fa-user-plus me-1"></i> Tambah Manual</button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="myTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>No WhatsApp</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $m)
                    <tr>
                        <td>{{ $m->nama }}</td>
                        <td>{{ $m->angkatan }}</td>
                        <td>{{ $m->no_wa }}</td>
                        <td class="text-center">
                            <a href="{{ route('members.show', $m->id) }}" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('members.destroy', $m->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus data ini?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('members.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header"><h5><i class="fas fa-user-edit me-2"></i>Tambah Anggota Baru</h5></div>
            <div class="modal-body row g-3">
                <div class="col-md-8"><label class="form-label">Nama Lengkap</label><input type="text" name="nama" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Angkatan</label><input type="number" name="angkatan" class="form-control" placeholder="2023" required></div>
                <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">No WhatsApp</label><input type="text" name="no_wa" class="form-control" placeholder="08..." required></div>
                <div class="col-md-6"><label class="form-label">No WhatsApp Orang Tua</label><input type="text" name="no_ortu" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Alamat Kos (Jember)</label><textarea name="alamat_kos" class="form-control" rows="2"></textarea></div>
                <div class="col-12"><label class="form-label">Alamat Asal (Orang Tua)</label><textarea name="alamat_ortu" class="form-control" rows="2"></textarea></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalImport" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('members.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header"><h5>Import Data Excel</h5></div>
            <div class="modal-body text-center p-4">
                <i class="fas fa-cloud-upload-alt fa-3x text-success mb-3"></i>
                <input type="file" name="file_excel" class="form-control" accept=".xlsx, .xls" required>
                <small class="text-muted mt-2 d-block">Urutan Kolom: Nama, Angkatan, Tgl Lahir, WA, WA Ortu, Kos, Alamat Asal</small>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success w-100">Upload & Proses</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
        });
    });
</script>
</body>
</html>

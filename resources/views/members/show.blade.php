<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail: {{ $member->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; padding-top: 50px; }
        .card-detail { border-radius: 20px; border: none; overflow: hidden; }
        .header-detail { background: #2c3e50; color: white; padding: 30px; }
    </style>
</head>
<body>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-detail shadow">
                <div class="header-detail text-center">
                    <i class="fas fa-user-circle fa-4x mb-3"></i>
                    <h2 class="mb-0">{{ $member->nama }}</h2>
                    <span class="badge bg-info mt-2">Angkatan {{ $member->angkatan }}</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6 border-end">
                            <h6 class="text-muted"><i class="fas fa-birthday-cake me-2"></i>Tanggal Lahir</h6>
                            <p class="fw-bold">{{ \Carbon\Carbon::parse($member->tanggal_lahir)->format('d F Y') }}</p>

                            <h6 class="text-muted mt-4"><i class="fab fa-whatsapp me-2"></i>No. WhatsApp</h6>
                            <p class="fw-bold">{{ $member->no_wa }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted"><i class="fas fa-home me-2"></i>Alamat Kos (Jember)</h6>
                            <p class="fw-bold">{{ $member->alamat_kos ?? '-' }}</p>

                            <h6 class="text-muted mt-4"><i class="fas fa-map-marked-alt me-2"></i>Alamat Orang Tua</h6>
                            <p class="fw-bold">{{ $member->alamat_ortu ?? '-' }}</p>
                        </div>
                        <div class="col-12 mt-4 bg-light p-3 rounded">
                            <h6 class="text-muted"><i class="fas fa-phone-alt me-2"></i>Kontak Darurat (Orang Tua)</h6>
                            <p class="mb-0 fw-bold">{{ $member->no_ortu ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('members.index') }}" class="btn btn-secondary px-4"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
                        <a href="https://wa.me/{{ $member->no_wa }}" target="_blank" class="btn btn-success px-4"><i class="fab fa-whatsapp me-2"></i> Hubungi WA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

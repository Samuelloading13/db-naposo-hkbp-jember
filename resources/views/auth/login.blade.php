<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - NHKBP Jember</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #003366;">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5 text-center">
                        <img src="https://upload.wikimedia.org/wikipedia/id/f/f3/Logo_HKBP.png" width="80" class="mb-4">
                        <h4 class="fw-bold mb-4">ADMIN LOGIN</h4>

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3 text-start">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control shadow-none @error('email') is-invalid @enderror" placeholder="admin@gmail.com" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-4 text-start">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control shadow-none" placeholder="********" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold" style="background-color: #003366;">MASUK</button>
                        </form>

                        <p class="mt-4 text-muted" style="font-size: 12px;">© 2026 NHKBP Jember</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

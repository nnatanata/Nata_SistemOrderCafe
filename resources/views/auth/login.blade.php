<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        }
        .card {
            border-radius: 12px;
        }
        .card-header {
            background-color: #0d3b66;
        }
        .btn-deep-blue {
            background-color: #0d3b66;
            border: none;
        }
        .btn-deep-blue:hover {
            background-color: #092a4a;
        }
        .form-control:focus {
            border-color: #0d3b66;
            box-shadow: 0 0 0 0.2rem rgba(13, 59, 102, 0.25);
        }
        a {
            color: #0d3b66;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg border-0">

            <div class="card-header text-center text-white fw-bold py-3">
                Login
            </div>

            <div class="card-body p-4">

                @if(session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Masukkan email"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-deep-blue w-100 text-white fw-semibold">
                        Login
                    </button>
                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Belum punya akun?
                        <a href="/register">Register di sini</a>
                    </small>
                </div>
            </div>
        </div>

        <p class="text-center text-white-50 mt-4 small">
            © {{ date('Y') }} Nata's Cafe
        </p>
    </div>
</div>
</body>
</html>

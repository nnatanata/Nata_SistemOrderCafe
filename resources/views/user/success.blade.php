<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Terima Kasih</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        }
        .card {
            border-radius: 14px;
        }
        .card-header {
            background-color: #0d3b66;
        }
        .icon-check {
            font-size: 64px;
            color: #0d3b66;
        }
        .btn-deep-blue {
            background-color: #0d3b66;
            border: none;
        }
        .btn-deep-blue:hover {
            background-color: #092a4a;
        }
    </style>
</head>

<body>

<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-6 col-lg-5">

        <div class="card shadow-lg border-0 text-center">

            <div class="card-header text-white fw-semibold py-3">
                Pesanan Berhasil
            </div>

            <div class="card-body p-4">
                <i class="bi bi-check-circle-fill icon-check mb-3"></i>

                <h4 class="fw-bold mb-2">Terima Kasih</h4>
                <p class="text-muted mb-1">
                    Pesanan Anda sedang diproses.
                </p>

                <a href="/user" class="btn btn-deep-blue text-white px-4 mt-3">
                    Kembali ke Menu
                </a>
            </div>
        </div>

        <p class="text-center text-white-50 mt-4 small">
            © {{ date('Y') }} Nata's Cafe
        </p>

    </div>
</div>

</body>
</html>

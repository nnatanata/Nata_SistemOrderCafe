<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        .main-sidebar { background-color: #0d1b3d !important; }

        .brand-link {
            background-color: #0b1633 !important;
            color: #ffffff !important;
            border-bottom: 1px solid #1e3a8a;
        }

        .brand-text { font-weight: bold; }

        .nav-sidebar .nav-link { color: #c7d2fe !important; }

        .nav-sidebar .nav-link.active {
            background-color: #1e3a8a !important;
            color: #ffffff !important;
        }

        .nav-icon { margin-right: 10px; }

        .main-header {
            background-color: #0b1633 !important;
            border-bottom: 1px solid #1e40af;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar .nav-link { color: #ffffff !important; }

        .content-wrapper { background-color: #f8fafc; }

        .card { border-radius: 10px; }

        .btn-success {
            background-color: #0d3b66;
            border: none;
        }

        .btn-success:hover { background-color: #092a4a; }

        .sidebar-mini.sidebar-collapse .brand-text { display: none; }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="/logout" class="nav-link">Logout</a>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar elevation-4">
        <a href="/user" class="brand-link text-center">
            <i class="fas fa-store"></i>
            <span class="brand-text ml-2">USER PANEL</span>
        </a>

        <div class="sidebar">
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu">

                    <li class="nav-item">
                        <a href="/user" class="nav-link active">
                            <i class="nav-icon fas fa-utensils"></i>
                            <p>Pesan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/user/orders/history" class="nav-link">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Riwayat Pesanan</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper p-4">

        <h4 class="mb-3">Pesan Makanan</h4>

        <form method="POST" action="{{ route('user.order') }}">
            @csrf

            <div class="row">
                @foreach($menus as $menu)
                <div class="col-md-4">
                    <div class="card shadow-sm p-3 mb-3">
                        <h5>{{ $menu->name }}</h5>
                        <p class="text-muted">
                            Rp {{ number_format($menu->price,0,',','.') }}
                        </p>

                        <input type="hidden" name="menu_id[]" value="{{ $menu->id }}">
                        <input type="hidden" class="price" value="{{ $menu->price }}">

                        <input
                            type="number"
                            name="quantity[]"
                            min="0"
                            value="0"
                            class="form-control quantity"
                            placeholder="Jumlah"
                        >
                    </div>
                </div>
                @endforeach
            </div>

            <div class="card shadow-sm p-3 mt-3">
                <h5>Total Harga</h5>
                <h4 class="text-success">
                    Rp <span id="total">0</span>
                </h4>

                <button class="btn btn-success w-100 mt-2">
                    Order
                </button>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
    function formatRupiah(angka) {
        return angka.toLocaleString('id-ID');
    }

    function hitungTotal() {
        let total = 0;

        $('.quantity').each(function () {
            let qty = parseInt($(this).val()) || 0;
            let price = parseInt($(this).closest('.card').find('.price').val());
            total += qty * price;
        });

        $('#total').text(formatRupiah(total));
    }

    $('.quantity').on('focus', function () {
        if ($(this).val() === '0') {
            $(this).val('');
        }
    });

    $('.quantity').on('blur', function () {
        if ($(this).val() === '' || parseInt($(this).val()) < 0) {
            $(this).val(0);
        }
        hitungTotal();
    });

    $('.quantity').on('input', function () {
        hitungTotal();
    });
</script>

</body>
</html>

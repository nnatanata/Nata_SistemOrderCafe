<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pesanan Masuk</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        .main-sidebar {
            background-color: #0d1b3d !important;
        }

        .brand-link {
            background-color: #0b1633 !important;
            color: #ffffff !important;
            border-bottom: 1px solid #1e3a8a;
            text-align: center;
        }

        .brand-text {
            font-weight: bold;
        }

        .nav-sidebar .nav-link {
            color: #c7d2fe !important;
        }

        .nav-sidebar .nav-link.active {
            background-color: #1e3a8a !important;
            color: #ffffff !important;
        }

        .nav-icon {
            margin-right: 10px;
        }

        .main-header {
            background-color: #0b1633 !important;
            border-bottom: 1px solid #1e40af;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar .nav-link {
            color: #ffffff !important;
        }

        .content-wrapper {
            background-color: #f8fafc;
        }

        .card {
            border-radius: 10px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-mini.sidebar-collapse .brand-text {
            display: none;
        }
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
        <a href="/admin" class="brand-link">
            <i class="fas fa-user-shield"></i>
            <span class="brand-text ml-2">ADMIN PANEL</span>
        </a>

        <div class="sidebar">
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu">

                    <li class="nav-item">
                        <a href="/admin"
                           class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Pesanan Masuk</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/admin/menu"
                           class="nav-link {{ request()->is('admin/menu*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-utensils"></i>
                            <p>Kelola Menu</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper p-4">
        <h4 class="mb-4">Pesanan Masuk</h4>

        @forelse ($groupedOrders as $batchCode => $batch)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    
                    <small>
                        Pemesan: {{ $batch->first()->user->name }} |
                        {{ \Carbon\Carbon::parse($batch->first()->order_date)->format('d M Y H:i') }}
                    </small>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="bg-light">
                        <tr>
                            <th>Menu</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $total = 0; @endphp
                        @foreach ($batch as $order)
                            @php $total += $order->total_price; @endphp
                            <tr>
                                <td>{{ $order->menu->name }}</td>
                                <td class="text-center">{{ $order->quantity }}</td>
                                <td class="text-right">
                                    Rp {{ number_format($order->total_price,0,',','.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-weight-bold bg-light">
                            <td colspan="2" class="text-right">Total Harga</td>
                            <td class="text-right text-primary">
                                Rp {{ number_format($total,0,',','.') }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                Belum ada pesanan masuk.
            </div>
        @endforelse
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        .main-sidebar { background-color: #0d1b3d !important; }

        .brand-link {
            background-color: #0b1633 !important;
            color: #fff !important;
            border-bottom: 1px solid #1e3a8a;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-text {
            font-weight: bold;
        }

        .nav-sidebar .nav-link { color: #c7d2fe !important; }

        .nav-sidebar .nav-link.active {
            background-color: #1e3a8a !important;
            color: #fff !important;
        }

        .main-header {
            background-color: #0b1633 !important;
            border-bottom: 1px solid #1e40af;
        }

        .content-wrapper { background-color: #f8fafc; }

        .sidebar-mini.sidebar-collapse .brand-text {
            display: none;
        }

        .sidebar-mini.sidebar-collapse .nav-sidebar .nav-link p {
            display: none;
        }

        .history-card {
            border-left: 5px solid #0d3b66;
            background: #f8fbff;
            border-radius: 8px;
        }

        .history-header {
            background: #0d3b66;
            color: #fff;
            padding: 10px 15px;
            border-radius: 6px 6px 0 0;
            font-weight: 600;
        }

        .history-table th {
            background: #1e5aa8;
            color: #fff;
            text-align: center;
        }

        .history-divider {
            height: 2px;
            background: #0d3b66;
            margin: 30px 0;
            opacity: 0.3;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
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
        <a href="/user" class="brand-link">
            <i class="fas fa-store"></i>
            <span class="brand-text ml-2">USER PANEL</span>
        </a>

        <div class="sidebar">
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column">

                    <li class="nav-item">
                        <a href="/user" class="nav-link">
                            <i class="nav-icon fas fa-utensils"></i>
                            <p>Pesan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/user/orders/history" class="nav-link active">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Riwayat Pesanan</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper p-4">
        <h4 class="mb-4" style="color:#0d3b66;font-weight:600;">
            Riwayat Pesanan
        </h4>

        @forelse($orders as $orderDate => $batch)
        <div class="history-card mb-4 shadow-sm">

            <div class="history-header">
                Tanggal Pesanan:
                {{ \Carbon\Carbon::parse($orderDate)->format('d M Y H:i') }}
            </div>

            <div class="p-3">
                <table class="table table-bordered history-table mb-0">
                    <tr>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>

                    @php $grandTotal = 0; @endphp
                    @foreach($batch as $order)
                        @php $grandTotal += $order->total_price; @endphp
                        <tr>
                            <td>{{ $order->menu->name }}</td>
                            <td class="text-center">{{ $order->quantity }}</td>
                            <td class="text-right">
                                Rp {{ number_format($order->total_price,0,',','.') }}
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="2" class="text-right font-weight-bold">
                            Total Pembelian
                        </td>
                        <td class="text-right font-weight-bold text-primary">
                            Rp {{ number_format($grandTotal,0,',','.') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="history-divider"></div>
        @empty
            <div class="alert alert-info">
                Belum ada riwayat pesanan.
            </div>
        @endforelse
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard User')</title>

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
                        <a href="/user" class="nav-link {{ request()->is('user') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-utensils"></i>
                            <p>Pesan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/user/orders/history"
                           class="nav-link {{ request()->is('user/orders/history') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Pesanan Anda</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper p-4">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@yield('scripts')

</body>
</html>

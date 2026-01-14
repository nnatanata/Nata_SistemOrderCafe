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
        .content-wrapper { background-color: #f8fafc; margin-left: 0 !important; width: 100%; }
        .wrapper { width: 100%; }
        .card { border-radius: 10px; }
        .btn-success {
            background-color: #0d3b66;
            border: none;
        }
        .btn-success:hover { background-color: #092a4a; }
        .sidebar-mini.sidebar-collapse .brand-text { display: none; }
    </style>
</head>

<body class="hold-transition layout-fixed">
<div class="wrapper">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background:#0b1633;">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('user.dashboard') }}">
            <i class="fas fa-store mr-2"></i>
            <span class="brand-text ml-1">Nata's Cafe</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#userNavbar" aria-controls="userNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="userNavbar">
            <ul class="navbar-nav">
                <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item {{ request()->routeIs('user.pesan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.pesan') }}">Pesan</a>
                </li>
                <li class="nav-item {{ request()->routeIs('user.orders.history') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.orders.history') }}">Riwayat</a>
                </li>
            </ul>
        </div>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
        </ul>
    </nav>

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

@extends('user.layout')

@section('title', 'Dashboard User')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0" style="color:#0d3b66;font-weight:700;">Hi, {{ auth()->user()->name ?? 'User' }}! 👋</h4>
        <div>
            <a href="{{ route('user.pesan') }}" class="btn btn-primary mr-2">Buat Pesanan Baru</a>
            <a href="{{ route('user.orders.history') }}" class="btn btn-outline-secondary">Lihat Semua Riwayat</a>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-2 text-primary"><i class="fas fa-receipt fa-2x"></i></div>
                    <h6 class="card-title">Total Pesanan</h6>
                    <p class="card-text display-4">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-2 text-success"><i class="fas fa-wallet fa-2x"></i></div>
                    <h6 class="card-title">Total Belanja (Selesai)</h6>
                    <p class="card-text h4">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-2 text-warning"><i class="fas fa-calendar-day fa-2x"></i></div>
                    <h6 class="card-title">Pesanan Hari Ini</h6>
                    <p class="card-text display-4">{{ $todayOrders }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-2 text-info"><i class="fas fa-clock fa-2x"></i></div>
                    <h6 class="card-title">Pesanan Terakhir</h6>
                    <p class="card-text">{{ $lastOrderDate }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-transparent">
                    <strong>Menu Favorit</strong>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $favoriteName }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent">
                    <strong>Pesanan Terbaru</strong>
                </div>
                <div class="card-body p-0">
                    @if(!empty($recentOrders) && count($recentOrders) > 0)
                        <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0 recent-orders-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $r)
                                    <tr>
                                        <td style="min-width:120px;"><small>{{ $r['date'] }}</small></td>
                                        <td class="text-center" style="width:70px;"><small>{{ count($r['items']) }}</small></td>
                                        <td class="text-right" style="min-width:120px;"><small>Rp {{ number_format($r['total'],0,',','.') }}</small></td>
                                        <td class="text-center" style="min-width:110px;">
                                            @php $s = $r['status']; $cls='badge-secondary'; if($s=='Baru') $cls='badge-primary'; if($s=='Diproses') $cls='badge-warning'; if($s=='Selesai') $cls='badge-success'; @endphp
                                            <span class="badge {{ $cls }}">{{ strtoupper($s) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    @else
                        <div class="p-3">Belum ada pesanan terakhir.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-transparent">
                    <strong>Tips & Bantuan</strong>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Pilih jumlah pada menu lalu tekan <strong>Buat Pesanan Baru</strong>.</li>
                        <li>Klik <strong>Lihat Semua Riwayat</strong> untuk detail transaksi.</li>
                        <li>Jika ada masalah, hubungi admin atau cek status pesanan di riwayat.</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent">
                    <strong>Quick Actions</strong>
                </div>
                <div class="card-body">
                    <a href="{{ route('user.pesan') }}" class="btn btn-success mb-2 w-100">Pesan Sekarang</a>
                    <a href="{{ route('user.orders.history') }}" class="btn btn-outline-primary w-100">Cek Status Pesanan</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card .card-body { min-height: 100px; }
    .display-4 { font-size: 2.25rem; font-weight: 700; }

    .recent-orders-table th, .recent-orders-table td { white-space: nowrap; }
    .recent-orders-table td small { white-space: nowrap; }
    .table-responsive { overflow-x: auto; }
    @media (max-width: 576px) {
        .recent-orders-table th, .recent-orders-table td { white-space: normal; }
    }
</style>
@endsection

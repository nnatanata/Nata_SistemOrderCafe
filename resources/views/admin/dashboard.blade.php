@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0" style="color:#0d3b66;font-weight:700;">Dashboard Admin</h4>
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
                    <div class="mb-2 text-warning"><i class="fas fa-inbox fa-2x"></i></div>
                    <h6 class="card-title">Pesanan Masuk</h6>
                    <p class="card-text display-4">{{ $incomingOrders }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-2 text-success"><i class="fas fa-check-circle fa-2x"></i></div>
                    <h6 class="card-title">Pesanan Selesai</h6>
                    <p class="card-text display-4">{{ $completedOrders }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-2 text-dark"><i class="fas fa-wallet fa-2x"></i></div>
                    <h6 class="card-title">Total Pendapatan</h6>
                    <p class="card-text h4 revenue-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">Total Menu</h6>
                    <p class="card-text h1">{{ $totalMenus }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">Pesanan Hari Ini</h6>
                    <p class="card-text h1">{{ $todayOrders }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">Menu Terlaris</h6>
                    <p class="card-text">{{ $topMenuName }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Grafik Pesanan (7 Hari)</div>
                <div class="card-body">
                    <canvas id="ordersChart" height="120"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent"><strong>Pesanan Terbaru</strong></div>
                <div class="card-body p-0">
                    @if(!empty($recentOrders) && count($recentOrders) > 0)
                        <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0 recent-orders-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $r)
                                    @php
                                        if (is_array($r)) {
                                            $rowDate = $r['date'] ?? '—';
                                            $rowCustomer = $r['customer_name'] ?? '—';
                                            $rowItems = isset($r['items']) ? count($r['items']) : ($r['items_count'] ?? 0);
                                            $rowTotal = $r['total'] ?? 0;
                                            $rowStatus = $r['status'] ?? 'Baru';
                                        } else {
                                            $rowDate = optional($r->created_at)->format('Y-m-d') ?? '—';
                                            $rowCustomer = $r->user->name ?? ($r->customer_name ?? '—');
                                            $rowItems = $r->items_count ?? (is_countable($r->items) ? count($r->items) : 0);
                                            $rowTotal = $r->total ?? 0;
                                            $rowStatus = $r->status ?? 'Baru';
                                        }
                                        $cls = 'badge-secondary';
                                        if($rowStatus=='Baru') $cls='badge-primary';
                                        if($rowStatus=='Diproses') $cls='badge-warning';
                                        if($rowStatus=='Selesai') $cls='badge-success';
                                    @endphp
                                    <tr>
                                        <td style="min-width:120px;"><small>{{ $rowDate }}</small></td>
                                        <td style="min-width:140px;"><small>{{ $rowCustomer }}</small></td>
                                        <td class="text-center" style="width:70px;"><small>{{ $rowItems }}</small></td>
                                        <td class="text-right" style="min-width:120px;"><small>Rp {{ number_format($rowTotal,0,',','.') }}</small></td>
                                        <td class="text-center" style="min-width:110px;">
                                            <span class="badge {{ $cls }}">{{ strtoupper($rowStatus) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    @else
                        <div class="p-3">Belum ada pesanan terbaru.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-transparent"><strong>Ringkasan</strong></div>
                <div class="card-body">
                    <p class="mb-1"><strong>Jumlah Pesanan:</strong> {{ $totalOrders }}</p>
                    <p class="mb-1"><strong>Pendapatan Total:</strong> Rp {{ number_format($totalRevenue ?? 0,0,',','.') }}</p>
                    <p class="mb-1"><strong>Menu Tersedia:</strong> {{ $totalMenus }}</p>
                    <p class="mb-0"><strong>Pesanan Hari Ini:</strong> {{ $todayOrders }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent"><strong>Quick Actions</strong></div>
                <div class="card-body">
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-success mb-2 w-100">Kelola Menu</a>
                    <a href="{{ route('admin.orders') }}" class="btn btn-outline-primary w-100">Kelola Pesanan</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card .card-body { min-height: 100px; }
    .display-4 { font-size: 2.25rem; font-weight: 700; }

    .revenue-value { white-space: normal; overflow-wrap: anywhere; font-weight:700; }

    .recent-orders-table th, .recent-orders-table td { white-space: nowrap; }
    .recent-orders-table td small { white-space: nowrap; }
    .table-responsive { overflow-x: auto; }
    @media (max-width: 576px) {
        .recent-orders-table th, .recent-orders-table td { white-space: normal; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($chartLabels ?? []);
    const ordersData = @json($chartOrders ?? []);
    const revenueData = @json($chartRevenues ?? []);
    const statusCounts = @json($statusCounts ?? []);

    const ctx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Jumlah Pesanan',
                    data: ordersData,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.08)',
                    tension: 0.3,
                    yAxisID: 'y',
                },
                {
                    label: 'Pendapatan (Rp)',
                    data: revenueData,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40,167,69,0.08)',
                    tension: 0.3,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true },
                y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } }
            }
        }
    });

    const statusLabels = Object.keys(statusCounts);
    const statusValues = Object.values(statusCounts);
    const ctx2 = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusValues,
                backgroundColor: ['#f39c12', '#00a65a', '#007bff', '#d2d6de']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endsection

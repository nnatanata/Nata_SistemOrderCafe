@extends('user.dashboard')

@section('title', 'Pesanan Anda')

@section('content')

<style>
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

<h4 class="mb-4" style="color:#0d3b66;font-weight:600;">
    Pesanan Anda
</h4>

@forelse($orders as $batchCode => $batch)
    <div class="history-card mb-4 shadow-sm">

        <div class="history-header">
            Tanggal Pesanan:
            {{ \Carbon\Carbon::parse($batch->first()->order_date)->format('d M Y H:i') }}
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
        Belum ada pesanan.
    </div>
@endforelse

@endsection

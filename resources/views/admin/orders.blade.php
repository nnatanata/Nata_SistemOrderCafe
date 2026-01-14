@extends('admin.layout')

@section('content')
<h4 class="mb-4">Pesanan Selesai</h4>

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
                    <th class="text-center">Menu</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Subtotal</th>
                </tr>
                </thead>

                <tbody>
                @php $total = 0; @endphp
                @foreach ($batch as $order)
                    @php $total += $order->total_price; @endphp
                    <tr>
                        <td>{{ $order->menu->name }}</td>
                        <td class="text-center">{{ $order->quantity }}</td>
                        <td class="text-center">
                            Rp {{ number_format($order->total_price,0,',','.') }}
                        </td>
                    </tr>
                @endforeach

                <tr class="font-weight-bold bg-light">
                    <td colspan="2" class="text-center">Total Harga</td>
                    <td class="text-center text-primary">
                        Rp {{ number_format($total,0,',','.') }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@empty
    <div class="alert alert-info">Belum ada pesanan selesai.</div>
@endforelse
@endsection

@extends('admin.dashboard')

@section('content')
<h4 class="mb-4">Pesanan Masuk</h4>

<style>
    .status-highlight {
        margin-top: 20px;
        padding: 10px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 0.95rem;
        text-align: center;
    }

    .status-diproses {
        background-color: #fef08a;
        color: #854d0e;
        border: 1px solid #fde047;
    }

    .status-selesai {
        background-color: #bbf7d0;
        color: #166534;
        border: 1px solid #4ade80;
    }
</style>

@forelse ($groupedOrders as $batchCode => $batch)
    @php $status = $batch->first()->status; @endphp

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
                    <th class="text-center">Status</th>
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

                        @if ($loop->first)
                            <td rowspan="{{ $batch->count() + 1 }}" class="align-top text-center">

                                <form method="POST"
                                      action="{{ route('admin.orders.updateStatus', $batchCode) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status"
                                            class="form-control form-control-sm"
                                            onchange="this.form.submit()">
                                        <option disabled selected>Ubah Status</option>
                                        <option value="Diproses">Diproses</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </form>

                                <div class="status-highlight
                                    {{ $status === 'Diproses' ? 'status-diproses' : 'status-selesai' }}">
                                    {{ strtoupper($status) }}
                                </div>
                            </td>
                        @endif
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
    <div class="alert alert-info">Belum ada pesanan masuk.</div>
@endforelse
@endsection

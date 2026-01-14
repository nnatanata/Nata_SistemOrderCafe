@extends('user.layout')

@section('title', 'Dashboard User')

@section('content')
<h4 class="mb-3">Pesan Makanan</h4>

<form method="POST" action="{{ route('user.order') }}">
    @csrf

    <div class="row">
        @foreach($menus as $menu)
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-3 menu-card">
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
@endsection

@section('scripts')
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
@endsection

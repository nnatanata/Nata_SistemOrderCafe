@extends('admin.dashboard')

@section('content')
<h4 class="mb-4">Kelola Menu</h4>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.menu.store') }}" class="mb-4">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <input name="name" class="form-control" placeholder="Nama Menu" required>
        </div>
        <div class="col-md-3">
            <input name="price" type="number" min="0" step="1" class="form-control" placeholder="Harga (contoh: 30000)" required>
        </div>
        <div class="col-md-3">
            <select name="is_available" class="form-control">
                <option value="1">Tersedia</option>
                <option value="0">Habis</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Tambah</button>
        </div>
    </div>
</form>

<table class="table table-bordered bg-white">
    <thead style="background:#0d1b3d;color:white">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Status</th>
            <th width="200">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($menus as $m)
        <tr>
            <td><strong>{{ 'A'.$m->id }}</strong></td>
            <td>{{ $m->name }}</td>
            <td>Rp {{ number_format($m->price,0,',','.') }}</td>

            <td>
                <form method="POST" action="{{ route('admin.menu.status', $m->id) }}">
                    @csrf
                    @method('PATCH')
                    <select name="is_available" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="1" {{ $m->is_available ? 'selected' : '' }}>Tersedia</option>
                        <option value="0" {{ !$m->is_available ? 'selected' : '' }}>Habis</option>
                    </select>
                </form>
            </td>

            <td class="text-center">
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit{{ $m->id }}">Edit</button>

                <form method="POST" action="{{ route('admin.menu.destroy', $m->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus menu ini?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>

        <div class="modal fade" id="edit{{ $m->id }}">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('admin.menu.update', $m->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Menu</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <input name="name" value="{{ $m->name }}" class="form-control mb-2" required>
                            <input name="price" type="number" min="0" step="1" value="{{ $m->price }}" class="form-control mb-2" required>
                            <select name="is_available" class="form-control">
                                <option value="1" {{ $m->is_available ? 'selected' : '' }}>Tersedia</option>
                                <option value="0" {{ !$m->is_available ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @endforeach
    </tbody>
</table>
@endsection

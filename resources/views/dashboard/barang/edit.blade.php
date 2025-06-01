@extends('dashboard.layouts.dashboard')

@section('content')
    <h2 class="mb-4">Edit Barang</h2>
    <form method="POST" action="{{ route('barang.update', $barang->id) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required value="{{ $barang->nama_barang }}">
        </div>
        <div class="form-group">
            <label>Jenis Barang</label>
            <input type="text" name="jenis_barang" class="form-control" required value="{{ $barang->jenis_barang }}">
        </div>
        <div class="form-group">
            <label>Merk</label>
            <input type="text" name="merk" class="form-control" required value="{{ $barang->merk }}">
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required min="0" value="{{ $barang->harga }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

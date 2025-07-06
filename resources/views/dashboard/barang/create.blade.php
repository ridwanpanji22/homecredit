@extends('dashboard.layouts.dashboard')

@section('content')
    <h2 class="mb-4">Tambah Barang</h2>
    <form method="POST" action="{{ route('barang.store') }}">
        @csrf
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Jenis Barang</label>
            <select name="jenis_barang" class="form-control" required>
                <option value="" disabled selected>Pilih Jenis Barang</option>
                <option value="Elektronik">Elektronik</option>
                <option value="Furniture">Furniture</option>
                <option value="Kendaraan">Kendaraan</option>
                <option value="Pakaian">Pakaian</option>
                <option value="Perhiasan">Perhiasan</option>
                <option value="Alat Rumah Tangga">Alat Rumah Tangga</option>
                <option value="Gadget">Gadget</option>
                <option value="Olahraga">Olahraga</option>
                <option value="Kesehatan">Kesehatan</option>
                <option value="Pendidikan">Pendidikan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Merk</label>
            <input type="text" name="merk" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required min="0">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

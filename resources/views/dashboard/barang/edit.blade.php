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
            <select name="jenis_barang" class="form-control" required>
                <option value="">Pilih Jenis Barang</option>
                <option value="Elektronik" {{ $barang->jenis_barang == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                <option value="Furniture" {{ $barang->jenis_barang == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                <option value="Kendaraan" {{ $barang->jenis_barang == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                <option value="Pakaian" {{ $barang->jenis_barang == 'Pakaian' ? 'selected' : '' }}>Pakaian</option>
                <option value="Perhiasan" {{ $barang->jenis_barang == 'Perhiasan' ? 'selected' : '' }}>Perhiasan</option>
                <option value="Alat Rumah Tangga" {{ $barang->jenis_barang == 'Alat Rumah Tangga' ? 'selected' : '' }}>Alat Rumah Tangga</option>
                <option value="Gadget" {{ $barang->jenis_barang == 'Gadget' ? 'selected' : '' }}>Gadget</option>
                <option value="Olahraga" {{ $barang->jenis_barang == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                <option value="Kesehatan" {{ $barang->jenis_barang == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                <option value="Pendidikan" {{ $barang->jenis_barang == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
            </select>
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

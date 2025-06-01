@extends('dashboard.layouts.dashboard')

@section('content')
@php
    // mengubah formar haga menjadi format rupiah
    $barangList = $barangList->map(function($barang) {
        $barang->harga = number_format($barang->harga, 0, ',', '.');
        return $barang;
    });
@endphp
    <h2>Tambah Kredit</h2>
    <form method="POST" action="{{ route('kredit.store') }}">
        @csrf
        <div class="form-group">
            <label>Nama Nasabah</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih Nasabah --</option>
                @foreach($nasabahList as $nasabah)
                    <option value="{{ $nasabah->id }}">{{ $nasabah->name }} ({{ $nasabah->phone }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Nama Barang</label>
            <select name="barang_id" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barangList as $barang)
                    <option value="{{ $barang->id }}">{{ $barang->nama_barang }} ({{ $barang->merk }}) Rp{{ $barang->harga }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" required>
        </div>
        <div class="form-group">
            <label>Total Harga</label>
            <input type="number" name="total_harga" class="form-control" min="0" required>
        </div>
        <div class="form-group">
            <label>Jenis Kredit</label>
            <select name="jenis_kredit" class="form-control" required>
                <option value="harian">Harian</option>
                <option value="mingguan">Mingguan</option>
                <option value="bulanan">Bulanan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tenor (bulan/periode)</label>
            <input type="number" name="tenor" class="form-control" min="1" required>
        </div>
        <div class="form-group">
            <label>Tanggal Mulai Kredit</label>
            <input type="date" name="tanggal_mulai" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Status Kredit</label>
            <select name="status" class="form-control" required>
                <option value="aktif">Aktif</option>
                <option value="lunas">Lunas</option>
                <option value="menunggak">Menunggak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Kredit</button>
        <a href="{{ route('kredit.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

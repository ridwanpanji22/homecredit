@extends('dashboard.layouts.dashboard')

@section('content')
    <h2>Edit Data Kredit</h2>
    <form method="POST" action="{{ route('kredit.update', $kredit->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Nasabah</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih Nasabah --</option>
                @foreach($nasabahList as $nasabah)
                    <option value="{{ $nasabah->id }}" {{ $kredit->user_id == $nasabah->id ? 'selected' : '' }}>
                        {{ $nasabah->name }} ({{ $nasabah->phone }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Nama Barang</label>
            <select name="barang_id" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barangList as $barang)
                    <option value="{{ $barang->id }}" {{ $kredit->barang_id == $barang->id ? 'selected' : '' }}>
                        {{ $barang->nama_barang }} ({{ $barang->merk }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" required value="{{ $kredit->jumlah }}">
        </div>
        <div class="form-group">
            <label>Total Harga</label>
            <input type="number" name="total_harga" class="form-control" min="0" required value="{{ $kredit->total_harga }}">
        </div>
        <div class="form-group">
            <label>Jenis Kredit</label>
            <select name="jenis_kredit" class="form-control" required>
                <option value="harian" {{ $kredit->jenis_kredit == 'harian' ? 'selected' : '' }}>Harian</option>
                <option value="mingguan" {{ $kredit->jenis_kredit == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                <option value="bulanan" {{ $kredit->jenis_kredit == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tenor (bulan/periode)</label>
            <input type="number" name="tenor" class="form-control" min="1" required value="{{ $kredit->tenor }}">
        </div>
        <div class="form-group">
            <label>Cicilan per Periode</label>
            <input type="number" name="cicilan_per_periode" class="form-control" min="0" required value="{{ $kredit->cicilan_per_periode }}">
        </div>
        <div class="form-group">
            <label>Tanggal Mulai Kredit</label>
            <input type="date" name="tanggal_mulai" class="form-control" required value="{{ $kredit->tanggal_mulai }}">
        </div>
        <div class="form-group">
            <label>Status Kredit</label>
            <select name="status" class="form-control" required>
                <option value="aktif" {{ $kredit->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="lunas" {{ $kredit->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="menunggak" {{ $kredit->status == 'menunggak' ? 'selected' : '' }}>Menunggak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('kredit.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

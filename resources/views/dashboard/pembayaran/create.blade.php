@extends('dashboard.layouts.dashboard')
@section('content')
    <h2>Tambah Pembayaran Kredit</h2>
    <form method="POST" action="{{ route('kredit.pembayaran.store', $kredit->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Tanggal Pembayaran</label>
            <input type="date" name="tanggal_pembayaran" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Jumlah Pembayaran</label>
            <input type="number" name="jumlah_pembayaran" class="form-control" required min="1">
        </div>
        <div class="form-group">
            <label>Bukti Transfer (Opsional)</label>
            <input type="file" name="bukti_transfer" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('kredit.pembayaran.index', $kredit->id) }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

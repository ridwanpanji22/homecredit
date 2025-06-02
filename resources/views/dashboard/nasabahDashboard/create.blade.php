@extends('dashboard.layouts.dashboard')

@section('content')
    <h2>Bayar Cicilan Kredit</h2>
    <form method="POST" action="{{ route('nasabah.pembayaran.store', $kredit->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Tanggal Pembayaran</label>
            <input type="date" name="tanggal_pembayaran" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Jumlah Pembayaran</label>
            <input type="number" name="jumlah_pembayaran" class="form-control" value="{{ $kredit->cicilan_per_periode }}" readonly>
        </div>
        <div class="form-group">
            <label>Bukti Transfer</label>
            <input type="file" name="bukti_transfer" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
    </form>
@endsection

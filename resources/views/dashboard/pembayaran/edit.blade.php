@extends('dashboard.layouts.dashboard')
@section('content')
    <h2>Edit Pembayaran Kredit</h2>
    <form method="POST" action="{{ route('kredit.pembayaran.update', [$kredit->id, $pembayaran->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Tanggal Pembayaran</label>
            <input type="date" name="tanggal_pembayaran" class="form-control" required value="{{ $pembayaran->tanggal_pembayaran }}">
        </div>
        <div class="form-group">
            <label>Jumlah Pembayaran</label>
            <input type="number" name="jumlah_pembayaran" class="form-control" required min="1" value="{{ $pembayaran->jumlah_pembayaran }}">
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="menunggu_verifikasi" {{ $pembayaran->status == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="terverifikasi" {{ $pembayaran->status == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="gagal" {{ $pembayaran->status == 'gagal' ? 'selected' : '' }}>Gagal</option>
            </select>
        </div>
        <div class="form-group">
            <label>Bukti Transfer (Opsional)</label>
            <input type="file" name="bukti_transfer" class="form-control">
            @if($pembayaran->bukti_transfer)
                <p><a href="{{ asset('storage/' . $pembayaran->bukti_transfer) }}" target="_blank">Lihat Bukti Lama</a></p>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('kredit.pembayaran.index', $kredit->id) }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

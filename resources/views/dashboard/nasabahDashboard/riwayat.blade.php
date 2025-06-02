@extends('dashboard.layouts.dashboard')

@section('content')
    <h2>Riwayat Pembayaran Cicilan</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pembayaran</th>
                <th>Jumlah Pembayaran</th>
                <th>Status Pembayaran</th>
                <th>Bukti Transfer</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatPembayaran as $pembayaran)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d-m-Y') }}</td>
                    <td>Rp{{ number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($pembayaran->status) }}</td>
                    <td>
                        @if($pembayaran->bukti_transfer)
                            <a href="{{ asset('storage/' . $pembayaran->bukti_transfer) }}" target="_blank" class="btn btn-info btn-sm">Lihat Bukti</a>
                        @else
                            <span class="text-muted">Belum ada bukti</span>
                        @endif
                    </td>
                    <td>
                        @if(in_array($pembayaran->status, ['menunggu_verifikasi', 'gagal']) || !$pembayaran->bukti_transfer)
                            <form action="{{ route('nasabah.pembayaran.upload-bukti', ['kredit' => $kredit->id, 'pembayaran' => $pembayaran->id]) }}" 
                                  method="POST" 
                                  enctype="multipart/form-data"
                                  class="upload-form">
                                @csrf
                                <div class="input-group">
                                    <input type="file" name="bukti_transfer" class="form-control form-control-sm" required accept="image/*,.pdf">
                                    <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                                </div>
                            </form>
                        @elseif($pembayaran->status === 'terverifikasi')
                            <span class="badge bg-success">Terverifikasi</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tombol untuk kembali ke dashboard -->
    <a href="{{ url('/nasabah/dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>

    <style>
        .upload-form {
            max-width: 300px;
        }
        .upload-form .input-group {
            margin-bottom: 0;
        }
    </style>
@endsection

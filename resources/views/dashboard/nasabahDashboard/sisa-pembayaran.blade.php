@extends('dashboard.layouts.dashboard')

@section('content')
    <div class="container">
        <h2>Riwayat Sisa Pembayaran</h2>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Kredit</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td>Nama Barang</td>
                                <td>: {{ $kredit->barang->nama_barang }}</td>
                            </tr>
                            <tr>
                                <td>Total Harga</td>
                                <td>: Rp{{ number_format($kredit->total_harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Total Pembayaran</td>
                                <td>: Rp{{ number_format($totalPembayaran, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Sisa Pembayaran</strong></td>
                                <td><strong>: Rp{{ number_format($sisaPembayaran, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Riwayat Sisa Pembayaran yang Belum Diverifikasi</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Jumlah Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatPembayaran as $pembayaran)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pembayaran->tanggal_pembayaran->format('d-m-Y') }}</td>
                                    <td>Rp{{ number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada pembayaran yang menunggu pembayaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('nasabah.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>
@endsection 
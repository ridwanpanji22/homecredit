@extends('dashboard.layouts.dashboard')

@section('content')
    <h2>Dashboard Nasabah</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- @dd($kredits) --}}
            @foreach($kredits as $kredit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kredit->barang->nama_barang }}</td>
                    <td>Rp{{ number_format($kredit->total_harga, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($kredit->status) }}</td>
                    <td>
                        <!-- Tombol yang mengarah ke riwayat pembayaran -->
                        <a href="{{ url('/nasabah/riwayat-pembayaran/'.$kredit->id) }}" class="btn btn-info btn-sm">Riwayat Pembayaran</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@extends('layouts.app')

@section('content')
    <h2>Riwayat Pembayaran Cicilan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pembayaran</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Bukti Transfer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatPembayaran as $pembayaran)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pembayaran->tanggal_pembayaran }}</td>
                    <td>Rp{{ number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($pembayaran->status) }}</td>
                    <td>
                        @if($pembayaran->bukti_transfer)
                            <a href="{{ asset('storage/' . $pembayaran->bukti_transfer) }}" target="_blank">Lihat Bukti</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

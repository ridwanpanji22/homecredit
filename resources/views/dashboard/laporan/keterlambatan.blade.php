@extends('dashboard.layouts.dashboard')
@section('content')
    <h2>Laporan Keterlambatan Pembayaran</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Nasabah</th>
                <th>Barang</th>
                <th>Jatuh Tempo</th>
                <th>Jumlah Menunggak</th>
                <th>Hari Telat</th>
            </tr>
        </thead>
        <tbody>
        @foreach($kredits as $kredit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kredit->user->name ?? '-' }}</td>
                <td>{{ $kredit->barang->nama_barang ?? '-' }}</td>
                <td>{{ $kredit->tanggalJatuhTempoSelanjutnya()->format('d-m-Y') }}</td>
                <td>Rp{{ number_format($kredit->cicilan_per_periode, 0, ',', '.') }}</td>
                <td>{{ floor(\Carbon\Carbon::parse($kredit->tanggalJatuhTempoSelanjutnya())->diffInDays(now())) }} Hari</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

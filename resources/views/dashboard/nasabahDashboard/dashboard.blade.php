@extends('layouts.app')

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
            @foreach($kredits as $kredit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kredit->barang->nama_barang }}</td>
                    <td>Rp{{ number_format($kredit->total_harga, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($kredit->status) }}</td>
                    <td><a href="{{ route('nasabah.pembayaran.create', $kredit->id) }}" class="btn btn-info btn-sm">Bayar Cicilan</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@extends('dashboard.layouts.dashboard')
@section('content')
    <h2>Laporan Data Kredit</h2>
    <form method="get" class="mb-3">
        <select name="status" onchange="this.form.submit()">
            <option value="">-- Semua Status --</option>
            <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="lunas" {{ $status == 'lunas' ? 'selected' : '' }}>Lunas</option>
            <option value="menunggak" {{ $status == 'menunggak' ? 'selected' : '' }}>Menunggak</option>
        </select>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Nasabah</th>
                <th>Barang</th>
                <th>Total Harga</th>
                <th>Status Kredit</th>
                <th>Total Sudah Dibayar</th>
                <th>Sisa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kredits as $kredit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kredit->user->name ?? '-' }}</td>
                    <td>{{ $kredit->barang->nama_barang ?? '-' }}</td>
                    <td>Rp{{ number_format($kredit->total_harga,0,',','.') }}</td>
                    <td>{{ ucfirst($kredit->status) }}</td>
                    <td>Rp{{ number_format($kredit->totalDibayar(),0,',','.') }}</td>
                    <td>Rp{{ number_format($kredit->sisaTagihan(),0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

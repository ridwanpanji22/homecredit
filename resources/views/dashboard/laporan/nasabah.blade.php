@extends('dashboard.layouts.dashboard')
@section('content')
    <h2>Laporan Kredit & Pembayaran Nasabah</h2>
    <form method="get" class="mb-3">
        <select name="nasabah_id" onchange="this.form.submit()">
            <option value="">-- Pilih Nasabah --</option>
            @foreach($nasabahList as $nasabah)
                <option value="{{ $nasabah->id }}" {{ $selectedNasabah == $nasabah->id ? 'selected' : '' }}>
                    {{ $nasabah->name }} ({{ $nasabah->phone }})
                </option>
            @endforeach
        </select>
    </form>
    @if($selectedNasabah)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
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
                        <td>{{ $kredit->barang->nama_barang ?? '-' }}</td>
                        <td>Rp{{ number_format($kredit->total_harga,0,',','.') }}</td>
                        <td>{{ ucfirst($kredit->status) }}</td>
                        <td>Rp{{ number_format($kredit->totalDibayar(),0,',','.') }}</td>
                        <td>Rp{{ number_format($kredit->sisaTagihan(),0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Pilih nasabah untuk melihat rekap.</div>
    @endif
@endsection

@extends('dashboard.layouts.dashboard')
@section('content')
    <h2>Laporan Data Pembayaran</h2>
    <form method="get" class="mb-3">
        <select name="status" onchange="this.form.submit()">
            <option value="">-- Semua Status --</option>
            <option value="terverifikasi" {{ $status == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
            <option value="menunggu_verifikasi" {{ $status == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
            <option value="gagal" {{ $status == 'gagal' ? 'selected' : '' }}>Gagal</option>
        </select>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Nasabah</th>
                <th>Barang</th>
                <th>Tanggal Pembayaran</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Bukti</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayarans as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->kredit->user->name ?? '-' }}</td>
                    <td>{{ $p->kredit->barang->nama_barang ?? '-' }}</td>
                    {{-- <td>{{ $p->tanggal_pembayaran }}</td> format tanggal indonesia--}}
                    <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal_pembayaran)->format('d-m-Y') }}</td>
                    <td>Rp{{ number_format($p->jumlah_pembayaran,0,',','.') }}</td>
                    <td class="text-center">{{ ucfirst($p->status) }}</td>
                    <td>
                        @if($p->bukti_transfer)
                            <a href="{{ asset('storage/' . $p->bukti_transfer) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

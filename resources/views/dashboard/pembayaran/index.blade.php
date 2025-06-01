@extends('dashboard.layouts.dashboard')
@section('content')
    <h2>Riwayat Pembayaran Kredit: {{ $kredit->barang->nama_barang ?? '-' }} Oleh <b>{{ $kredit->user->name ?? '-' }}</b> </h2>
    <a href="{{ route('kredit.pembayaran.create', $kredit->id) }}" class="btn btn-primary mb-3">Tambah Pembayaran</a>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pembayaran</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Bukti Transfer</th>
                <th>Verifikasi</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        {{-- @foreach($pembayarans as $row) --}}
        {{-- mengurutkan berdasarkan tanggal paling lama --}}
        @foreach($pembayarans->sortBy('tanggal_pembayaran') as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                {{-- <td>{{ $row->tanggal_pembayaran }}</td> format tanggal indonesia --}}
                <td class="text-center">{{ \Carbon\Carbon::parse($row->tanggal_pembayaran)->format('d-m-Y') }}</td>
                <td>Rp{{ number_format($row->jumlah_pembayaran, 0, ',', '.') }}</td>
                <td>{{ ucfirst($row->status) }}</td>
                <td>
                    @if($row->bukti_transfer)
                        <a href="{{ asset('storage/' . $row->bukti_transfer) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">
                    @if($row->status == 'menunggu_verifikasi')
                        <form action="{{ route('kredit.pembayaran.verifikasi', [$kredit->id, $row->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Verifikasi pembayaran ini?')">Verifikasi</button>
                        </form>
                        <form action="{{ route('kredit.pembayaran.tolak', [$kredit->id, $row->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak pembayaran ini?')">Tolak</button>
                        </form>
                    @endif
                </td>
                <td>
                    <a href="{{ route('kredit.pembayaran.edit', [$kredit->id, $row->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kredit.pembayaran.destroy', [$kredit->id, $row->id]) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pembayaran ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('kredit.index') }}" class="btn btn-secondary">Kembali</a>
@endsection

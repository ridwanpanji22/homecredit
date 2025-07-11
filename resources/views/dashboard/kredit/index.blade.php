@extends('dashboard.layouts.dashboard')

@section('content')
    <h2>Daftar Kredit</h2>
    <a href="{{ route('kredit.create') }}" class="btn btn-primary mb-3">Tambah Kredit</a>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <table class="table table-bordered" id="datatable-kredit">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Nasabah</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Jenis Kredit</th>
                <th>Tenor</th>
                <th>Cicilan/Periode</th>
                <th>Tanggal Mulai</th>
                <th>Status</th>
                <th>Total Sudah Dibayar</th>
                <th>Sisa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($kredits as $kredit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kredit->user->name ?? '-' }}</td>
                <td>{{ $kredit->barang->nama_barang ?? '-' }}</td>
                <td>{{ $kredit->jumlah }}</td>
                <td>Rp{{ number_format($kredit->total_harga, 0, ',', '.') }}</td>
                <td>{{ ucfirst($kredit->jenis_kredit) }}</td>
                <td>{{ $kredit->tenor }}</td>
                <td>Rp{{ number_format($kredit->cicilan_per_periode, 0, ',', '.') }}</td>
                {{-- <td>{{ $kredit->tanggal_mulai }}</td>  format tanggal indonesia--}}
                <td>{{ \Carbon\Carbon::parse($kredit->tanggal_mulai)->format('d-m-Y') }}</td>
                <td>{{ ucfirst($kredit->status) }}</td>
                <td>Rp{{ number_format($kredit->totalDibayar(), 0, ',', '.') }}</td>
                <td>Rp{{ number_format($kredit->sisaTagihan(), 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('kredit.pembayaran.index', $kredit->id) }}" class="btn btn-info btn-sm">Pembayaran</a>
                    <a href="{{ route('kredit.edit', $kredit->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kredit.destroy', $kredit->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kredit ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable-kredit').DataTable();
        });
    </script>
@endsection

@extends('dashboard.layouts.dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Laporan Nasabah</h2>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
    <form method="get" class="mb-3">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Pilih Nasabah</label>
                        <select name="nasabah_id" class="form-select" onchange="this.form.submit()">
                            <option value="" disabled selected>Pilih Nasabah</option>
            @foreach($nasabahList as $nasabah)
                                <option value="{{ $nasabah->id }}" {{ request('nasabah_id') == $nasabah->id ? 'selected' : '' }}>
                                    {{ $nasabah->name }}
                </option>
            @endforeach
        </select>
                    </div>
                </div>
    </form>
        </div>
    </div>

    <!-- Tabel Kredit Nasabah -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                            <th>Nasabah</th>
                    <th>Barang</th>
                            <th>Total Kredit</th>
                            <th>Total Dibayar</th>
                            <th>Sisa Tagihan</th>
                            <th>Status</th>
                            <th>Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kredits as $kredit)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                                <td>{{ $kredit->user->name }}</td>
                                <td>{{ $kredit->barang->nama_barang }}</td>
                                <td>Rp{{ number_format($kredit->total_harga, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($kredit->totalDibayar(), 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($kredit->sisaTagihan(), 0, ',', '.') }}</td>
                                <td>
                                    @if($kredit->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($kredit->status == 'lunas')
                                        <span class="badge bg-primary">Lunas</span>
                                    @else
                                        <span class="badge bg-danger">Menunggak</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $progress = ($kredit->totalDibayar() / $kredit->total_harga) * 100;
                                    @endphp
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                                             aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                            {{ number_format($progress, 1) }}%
                                        </div>
                                    </div>
                                </td>
                    </tr>
                @endforeach
            </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th>Rp{{ number_format($kredits->sum('total_harga'), 0, ',', '.') }}</th>
                            <th>Rp{{ number_format($kredits->sum(function($kredit) { return $kredit->totalDibayar(); }), 0, ',', '.') }}</th>
                            <th>Rp{{ number_format($kredits->sum(function($kredit) { return $kredit->sisaTagihan(); }), 0, ',', '.') }}</th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
        </table>
            </div>
        </div>
    </div>

    <!-- Statistik Nasabah -->
    @if(request('nasabah_id'))
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="paymentTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Pembayaran</th>
                                        <th>Status</th>
                                        <th>Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalPembayaran = 0; @endphp
                                    @forelse($kredits->first()->pembayarans as $index => $pembayaran)
                                        @if($pembayaran->status != 'menunggu_verifikasi' || $pembayaran->bukti_transfer)
                                            @php 
                                                if ($pembayaran->status == 'terverifikasi') {
                                                    $totalPembayaran += $pembayaran->jumlah_pembayaran;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d/m/Y') }}</td>
                                                <td>Rp{{ number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') }}</td>
                                                <td>
                                                    @if($pembayaran->status == 'terverifikasi')
                                                        <span class="badge bg-success">Terverifikasi</span>
                                                    @elseif($pembayaran->status == 'menunggu_verifikasi')
                                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                    @else
                                                        <span class="badge bg-danger">Gagal</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($pembayaran->bukti_transfer)
                                                        <a href="{{ asset('storage/' . $pembayaran->bukti_transfer) }}" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-info">
                                                            Lihat Bukti
                                                        </a>
    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data pembayaran</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if($kredits->first()->pembayarans->count() > 0)
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-end">Total Dibayar:</th>
                                            <th colspan="3">Rp{{ number_format($totalPembayaran, 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
<style>
.progress { height: 20px; }
.progress-bar { background-color: #4e73df; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi DataTable untuk tabel utama
    $('#dataTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Inisialisasi DataTable untuk tabel pembayaran
    $('#paymentTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        order: [[1, 'desc']] // Urutkan berdasarkan tanggal (kolom kedua) secara descending
    });
});
</script>
@endpush

@endsection

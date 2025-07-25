@extends('dashboard.layouts.dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Laporan Pembayaran</h2>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="get" class="mb-3">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>Gagal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nasabah</label>
                        <select name="nasabah_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Nasabah</option>
                            @foreach($nasabahList as $nasabah)
                                <option value="{{ $nasabah->id }}" {{ (request('nasabah_id') == $nasabah->id) ? 'selected' : '' }}>{{ $nasabah->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3 mt-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('laporan.pembayaran') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pembayaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($totalPembayaran, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Piutang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($totalPiutang, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Tunggakan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($totalTunggakan, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pembayaran -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nasabah</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayarans as $p)
                            @if($p->status != 'menunggu_verifikasi' || ($p->status == 'menunggu_verifikasi' && $p->bukti_transfer))
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_pembayaran)->format('d/m/Y') }}</td>
                                <td>{{ $p->kredit->user->name }}</td>
                                <td>{{ $p->kredit->barang->nama_barang }}</td>
                                <td>Rp{{ number_format($p->jumlah_pembayaran, 0, ',', '.') }}</td>
                                <td>
                                    @if($p->status == 'terverifikasi')
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @elseif($p->status == 'menunggu_verifikasi')
                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                    @else
                                        <span class="badge bg-danger">Gagal</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->bukti_transfer)
                                        <a href="{{ asset('storage/' . $p->bukti_transfer) }}" 
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
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th colspan="3">Rp{{ number_format($pembayarans->filter(function($p) {
                                return $p->status != 'menunggu_verifikasi' || 
                                       ($p->status == 'menunggu_verifikasi' && $p->bukti_transfer);
                            })->sum('jumlah_pembayaran'), 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
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
$(document).ready(function() {
    $('#dataTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>
@endpush 

@endsection

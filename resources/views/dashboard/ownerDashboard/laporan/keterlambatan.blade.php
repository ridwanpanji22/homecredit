@extends('dashboard.layouts.dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Laporan Keterlambatan Pembayaran</h2>

    <!-- Ringkasan Keterlambatan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Kredit Menunggak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kredits->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Tunggakan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp{{ number_format($kredits->sum(function($kredit) { return $kredit->sisaTagihan(); }), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-rata Keterlambatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ floor($kredits->avg(function($kredit) {
                                    return $kredit->tanggalJatuhTempoSelanjutnya()->diffInDays(now());
                                })) }} Hari
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Persentase Menunggak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format(($kredits->count() / \App\Models\Kredit::count()) * 100, 1) }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Keterlambatan -->
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
                            <th>Sisa Tagihan</th>
                            <th>Jatuh Tempo</th>
                            <th>Keterlambatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kredits as $kredit)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kredit->user->name }}</td>
                                <td>{{ $kredit->barang->nama_barang }}</td>
                                <td>Rp{{ number_format($kredit->total_harga, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($kredit->sisaTagihan(), 0, ',', '.') }}</td>
                                <td>{{ $kredit->tanggalJatuhTempoSelanjutnya()->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $keterlambatan = floor($kredit->tanggalJatuhTempoSelanjutnya()->diffInDays(now()));
                                    @endphp
                                    <span class="badge bg-danger">{{ $keterlambatan }} Hari</span>
                                </td>
                                <td>
                                    @if($keterlambatan > 90)
                                        <span class="badge bg-danger">Sangat Kritis</span>
                                    @elseif($keterlambatan > 60)
                                        <span class="badge bg-warning">Kritis</span>
                                    @else
                                        <span class="badge bg-info">Menunggak</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
<style>
.border-left-danger { border-left: 4px solid #e74a3b !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }
.border-left-info { border-left: 4px solid #36b9cc !important; }
.border-left-primary { border-left: 4px solid #4e73df !important; }
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
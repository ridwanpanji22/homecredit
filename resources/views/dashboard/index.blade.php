@extends('dashboard.layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<h2 class="mb-4">Dashboard Admin</h2>

<!-- Kartu Ringkasan -->
<div class="row mb-4">
    <div class="col-xl-2-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kredit</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKredit }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Nasabah</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalNasabah }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Kredit Menunggak -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Kredit Menunggak</h6>
            </div>
            <div class="card-body">
                @if($kreditMenunggak->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nasabah</th>
                                    <th>Jumlah Tunggakan</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Hari Telat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kreditMenunggak as $kredit)
                                    <tr>
                                        <td>{{ $kredit->user->name }}</td>
                                        <td>Rp{{ number_format($kredit->sisaTagihan(), 0, ',', '.') }}</td>
                                        <td>{{ $kredit->tanggalJatuhTempoSelanjutnya()->format('d/m/Y') }}</td>
                                        <td>{{ floor($kredit->tanggalJatuhTempoSelanjutnya()->diffInDays(now())) }} Hari</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">Tidak ada kredit yang menunggak</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.border-left-primary { border-left: 4px solid #4e73df !important; }
.border-left-success { border-left: 4px solid #1cc88a !important; }
.border-left-info { border-left: 4px solid #36b9cc !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }
.border-left-danger { border-left: 4px solid #e74a3b !important; }
@media (min-width: 1200px) {
    .col-xl-2-4 {
        flex: 0 0 20%;
        max-width: 20%;
    }
}
</style>
@endpush
@endsection
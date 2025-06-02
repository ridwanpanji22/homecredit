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
                            <option value="">Semua Nasabah</option>
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
            <div class="col-xl-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="paymentHistoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status Kredit</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie">
                            <canvas id="creditStatusChart"></canvas>
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
.chart-area, .chart-pie { height: 300px; position: relative; }
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    @if(request('nasabah_id'))
        // Data untuk grafik riwayat pembayaran
        var paymentCtx = document.getElementById('paymentHistoryChart').getContext('2d');
        new Chart(paymentCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($kredits->first()->pembayarans->pluck('tanggal_pembayaran')->map(function($date) {
                    return \Carbon\Carbon::parse($date)->format('d/m/Y');
                })) !!},
                datasets: [{
                    label: 'Jumlah Pembayaran',
                    data: {!! json_encode($kredits->first()->pembayarans->pluck('jumlah_pembayaran')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Data untuk grafik status kredit
        var statusCtx = document.getElementById('creditStatusChart').getContext('2d');
        var statusData = {
            aktif: {{ $kredits->where('status', 'aktif')->count() }},
            lunas: {{ $kredits->where('status', 'lunas')->count() }},
            menunggak: {{ $kredits->where('status', 'menunggak')->count() }}
        };

        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Aktif', 'Lunas', 'Menunggak'],
                datasets: [{
                    data: [statusData.aktif, statusData.lunas, statusData.menunggak],
                    backgroundColor: ['#1cc88a', '#4e73df', '#e74a3b']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    @endif
});
</script>
@endpush 

@endsection
@extends('dashboard.layouts.dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Laporan Kredit</h2>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="get" class="mb-3">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Status Kredit</label>
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="menunggak" {{ request('status') == 'menunggak' ? 'selected' : '' }}>Menunggak</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Kredit -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nasabah</th>
                            <th>Barang</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Total Dibayar</th>
                            <th>Sisa Tagihan</th>
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
                                <td>
                                    @if($kredit->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($kredit->status == 'lunas')
                                        <span class="badge bg-primary">Lunas</span>
                                    @else
                                        <span class="badge bg-danger">Menunggak</span>
                                    @endif
                                </td>
                                <td>Rp{{ number_format($kredit->totalDibayar(), 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($kredit->sisaTagihan(), 0, ',', '.') }}</td>
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
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
.progress { height: 20px; }
.progress-bar { background-color: #4e73df; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
        }
    });
});
</script>
@endpush 

@endsection
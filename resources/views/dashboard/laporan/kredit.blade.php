@extends('dashboard.layouts.dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Laporan Data Kredit</h2>

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
                    <div class="col-md-3">
                        <label class="form-label">Jenis Barang</label>
                        <select name="jenis_barang" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Jenis</option>
                            @foreach($jenisBarangList as $jenis)
                                <option value="{{ $jenis }}" {{ request('jenis_barang') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                            @endforeach
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
                            <th>Jenis Barang</th>
                            <th>Nama Barang</th>
                            <th>Tanggal Dikreditkan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kredits as $kredit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                                <td>{{ $kredit->user->name }}</td>
                                <td>{{ $kredit->barang->jenis_barang }}</td>
                                <td>{{ $kredit->barang->nama_barang }}</td>
                                <td>{{ $kredit->created_at->format('d/m/Y') }}</td>
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

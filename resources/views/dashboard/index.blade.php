@extends('dashboard.layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <h2 class="mb-4">Daftar Nasabah</h2>

    <a class="btn btn-primary mb-3" href="{{ route('admin.create') }}">Tambah Nasabah</a>

    {{-- tampilkan pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered" id="table">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama Nasabah</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Status Kredit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="nasabahTable">
            @foreach($nasabahList as $nasabah)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $nasabah->name }}</td>
                    <td>{{ $nasabah->email }}</td>
                    <td>{{ $nasabah->phone }}</td>
                    <td></td> <!-- Status kredit, sementara kosong -->
                    <td>
                        <a href="{{ route('admin.edit', $nasabah->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.destroy', $nasabah->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <!-- Tambahkan data nasabah lainnya di sini -->
        </tbody>
    </table>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
@endsection
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
                <th>No. KTP</th>
                <th>Foto KTP</th>
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
                    <td>{{ $nasabah->no_ktp ?? '-' }}</td>
                    <td>
                        @if($nasabah->foto_ktp)
                            <img src="{{ asset('storage/' . $nasabah->foto_ktp) }}" alt="Foto KTP" width="60" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#ktpModal" data-img="{{ asset('storage/' . $nasabah->foto_ktp) }}">
                        @else
                            -
                        @endif
                    </td>
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

<!-- Modal untuk Foto KTP -->
<div class="modal fade" id="ktpModal" tabindex="-1" aria-labelledby="ktpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ktpModalLabel">Foto KTP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="" id="ktpModalImg" alt="Foto KTP" class="img-fluid w-100">
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JS (untuk modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable();
        // Event untuk menampilkan gambar besar di modal
        $('#ktpModal').on('show.bs.modal', function (event) {
            var img = $(event.relatedTarget); // Gambar yang diklik
            var src = img.data('img');
            $('#ktpModalImg').attr('src', src);
        });
    });
</script>
@endsection
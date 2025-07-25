@extends('dashboard.layouts.dashboard')

@section('content')
    <h2>Edit Nasabah</h2>
    <form method="POST" action="{{ route('admin.update', $nasabah->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Nasabah</label>
            <input type="text" name="name" class="form-control" value="{{ $nasabah->name }}" required>
        </div>
        <div class="form-group">
            <label>No HP</label>
            <input type="text" name="phone" class="form-control" value="{{ $nasabah->phone }}" required>
        </div>
        <div class="form-group">
            <label>No. KTP</label>
            <input type="text" name="no_ktp" class="form-control" value="{{ $nasabah->no_ktp }}" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $nasabah->email }}" required>
        </div>
        <div class="form-group">
            <label>Password (isi jika ingin mengubah)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label>Foto KTP</label>
            <input type="file" name="foto_ktp" class="form-control" accept="image/*">
            @if($nasabah->foto_ktp)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $nasabah->foto_ktp) }}" alt="Foto KTP" width="120">
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

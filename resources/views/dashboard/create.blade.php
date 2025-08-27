@extends('dashboard.layouts.dashboard')

@section('content')
    <h2>Tambah Nasabah</h2>
    <form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Nasabah</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>No HP</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="form-group">
            <label>No. KTP</label>
            <input type="text" name="no_ktp" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Foto Identitas</label>
            <input type="file" name="foto_ktp" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection

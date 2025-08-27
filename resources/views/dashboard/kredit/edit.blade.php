@extends('dashboard.layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Kredit</h2>

    <form action="{{ route('kredit.update', $kredit->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="user_id" class="form-label">Nama Nasabah</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option value="">Pilih Nasabah</option>
                        @foreach($nasabahList as $nasabah)
                            <option value="{{ $nasabah->id }}" {{ $kredit->user_id == $nasabah->id ? 'selected' : '' }}>{{ $nasabah->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="barang_id" class="form-label">Nama Barang</label>
                    <select class="form-select" id="barang_id" name="barang_id" required>
                        <option value="">Pilih Barang</option>
                        @foreach($barangList as $barang)
                            <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}" {{ $kredit->barang_id == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }} - Rp{{ number_format($barang->harga, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" value="{{ $kredit->jumlah }}" required>
                </div>

                <div class="mb-3">
                    <label for="uang_muka" class="form-label">Uang Muka (%)</label>
                    <input type="number" class="form-control" id="uang_muka" name="uang_muka" min="0" max="100" value="{{ $kredit->uang_muka }}" step="0.01">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="jenis_kredit" class="form-label">Jenis Kredit</label>
                    <select class="form-select" id="jenis_kredit" name="jenis_kredit" required>
                        <option value="">Pilih Jenis Kredit</option>
                        <option value="harian" {{ $kredit->jenis_kredit == 'harian' ? 'selected' : '' }}>Harian (+15%)</option>
                        <option value="mingguan" {{ $kredit->jenis_kredit == 'mingguan' ? 'selected' : '' }}>Mingguan (+10%)</option>
                        <option value="bulanan" {{ $kredit->jenis_kredit == 'bulanan' ? 'selected' : '' }}>Bulanan (+5%)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tenor" class="form-label">Tenor (bulan/periode)</label>
                    <input type="number" class="form-control" id="tenor" name="tenor" min="1" value="{{ $kredit->tenor }}" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Kredit</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $kredit->tanggal_mulai }}" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Kredit</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="aktif" {{ $kredit->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="lunas" {{ $kredit->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="menunggak" {{ $kredit->status == 'menunggak' ? 'selected' : '' }}>Menunggak</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Informasi Kalkulasi -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Kalkulasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <strong>Harga Satuan:</strong><br>
                                    <span id="hargaSatuan">Rp 0</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <strong>Subtotal:</strong><br>
                                    <span id="subtotal">Rp 0</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <strong>Markup:</strong><br>
                                    <span id="markup">Rp 0</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <strong>Total Harga:</strong><br>
                                    <span id="totalHarga" class="text-primary fw-bold">Rp 0</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <strong>Uang Muka:</strong><br>
                                    <span id="jumlahUangMuka" class="text-success">Rp 0</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <strong>Sisa Kredit:</strong><br>
                                    <span id="sisaKredit" class="text-warning">Rp 0</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <strong>Cicilan per Tenor:</strong><br>
                                    <span id="cicilanPerTenor" class="text-info">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden input untuk total_harga -->
        <input type="hidden" id="total_harga" name="total_harga" value="{{ $kredit->total_harga }}">
        <input type="hidden" id="cicilan_per_periode" name="cicilan_per_periode" value="{{ $kredit->cicilan_per_periode }}">

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update Kredit</button>
            <a href="{{ route('kredit.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const barangSelect = document.getElementById('barang_id');
    const jumlahInput = document.getElementById('jumlah');
    const uangMukaInput = document.getElementById('uang_muka');
    const jenisKreditSelect = document.getElementById('jenis_kredit');
    const tenorInput = document.getElementById('tenor');
    
    // Elements untuk menampilkan hasil kalkulasi
    const hargaSatuanSpan = document.getElementById('hargaSatuan');
    const subtotalSpan = document.getElementById('subtotal');
    const markupSpan = document.getElementById('markup');
    const totalHargaSpan = document.getElementById('totalHarga');
    const jumlahUangMukaSpan = document.getElementById('jumlahUangMuka');
    const sisaKreditSpan = document.getElementById('sisaKredit');
    const cicilanPerTenorSpan = document.getElementById('cicilanPerTenor');
    
    // Hidden inputs
    const totalHargaInput = document.getElementById('total_harga');
    const cicilanPerPeriodeInput = document.getElementById('cicilan_per_periode');

    function hitungKredit() {
        const selectedOption = barangSelect.options[barangSelect.selectedIndex];
        const hargaSatuan = selectedOption.dataset.harga ? parseFloat(selectedOption.dataset.harga) : 0;
        const jumlah = parseInt(jumlahInput.value) || 0;
        const uangMuka = parseFloat(uangMukaInput.value) || 0;
        const jenisKredit = jenisKreditSelect.value;
        const tenor = parseInt(tenorInput.value) || 0;

        // Hitung subtotal
        const subtotal = hargaSatuan * jumlah;
        
        // Hitung markup berdasarkan jenis kredit
        let markup = 0;
        let markupPersen = 0;
        switch(jenisKredit) {
            case 'harian':
                markupPersen = 15;
                break;
            case 'mingguan':
                markupPersen = 10;
                break;
            case 'bulanan':
                markupPersen = 5;
                break;
        }
        markup = subtotal * (markupPersen / 100);
        
        // Total harga setelah markup
        const totalHarga = subtotal + markup;
        
        // Hitung uang muka
        const jumlahUangMuka = totalHarga * (uangMuka / 100);
        const sisaKredit = totalHarga - jumlahUangMuka;
        
        // Hitung cicilan per tenor
        const cicilanPerTenor = tenor > 0 ? sisaKredit / tenor : 0;

        // Update tampilan
        hargaSatuanSpan.textContent = `Rp ${hargaSatuan.toLocaleString('id-ID')}`;
        subtotalSpan.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        markupSpan.textContent = `Rp ${markup.toLocaleString('id-ID')} (${markupPersen}%)`;
        totalHargaSpan.textContent = `Rp ${totalHarga.toLocaleString('id-ID')}`;
        jumlahUangMukaSpan.textContent = `Rp ${jumlahUangMuka.toLocaleString('id-ID')}`;
        sisaKreditSpan.textContent = `Rp ${sisaKredit.toLocaleString('id-ID')}`;
        cicilanPerTenorSpan.textContent = `Rp ${cicilanPerTenor.toLocaleString('id-ID')}`;

        // Update hidden inputs
        totalHargaInput.value = totalHarga;
        cicilanPerPeriodeInput.value = cicilanPerTenor;
    }

    // Event listeners
    barangSelect.addEventListener('change', hitungKredit);
    jumlahInput.addEventListener('input', hitungKredit);
    uangMukaInput.addEventListener('input', hitungKredit);
    jenisKreditSelect.addEventListener('change', hitungKredit);
    tenorInput.addEventListener('input', hitungKredit);

    // Hitung kredit saat halaman dimuat
    hitungKredit();
});
</script>
@endsection

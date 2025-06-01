<header class="bg-success text-white text-center p-3">
    <h1>Pengelolaan Riwayat Pembayaran Kredit</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('admin.index') }}">Menu</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('barang.index') }}">Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kredit.index') }}">Kredit</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Laporan
                    </a>
                    <div class="dropdown-menu" aria-labelledby="laporanDropdown">
                        <a class="dropdown-item" href="{{ route('laporan.kredit') }}">Laporan Kredit</a>
                        <a class="dropdown-item" href="{{ route('laporan.pembayaran') }}">Laporan Pembayaran</a>
                        <a class="dropdown-item" href="{{ route('laporan.nasabah') }}">Laporan Nasabah</a>
                        <a class="dropdown-item" href="{{ route('laporan.keterlambatan') }}">Laporan Keterlambatan</a>

                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" id="logoutBtn">Keluar</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
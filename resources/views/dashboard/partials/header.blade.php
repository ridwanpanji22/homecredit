<header class="bg-success text-white text-center p-3">
    <h1>Pengelolaan Riwayat Pembayaran Kredit</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            @if(auth()->user()->role === 'admin')
                <a class="navbar-brand" href="{{ route('admin.index') }}">Dashboard Admin</a>
            @elseif(auth()->user()->role === 'nasabah')
                <a class="navbar-brand" href="{{ route('nasabah.dashboard') }}">Dashboard Nasabah</a>
            @else
                <a class="navbar-brand" href="{{ route('owner.dashboard') }}">Dashboard Owner</a>
            @endif

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index') }}">Kelola Nasabah</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('barang.index') }}">Kelola Barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kredit.index') }}">Kelola Kredit</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Laporan
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="laporanDropdown">
                                <li><a class="dropdown-item" href="{{ route('laporan.kredit') }}">Laporan Kredit</a></li>
                                <li><a class="dropdown-item" href="{{ route('laporan.pembayaran') }}">Laporan Pembayaran</a></li>
                                <li><a class="dropdown-item" href="{{ route('laporan.nasabah') }}">Laporan Nasabah</a></li>
                                <li><a class="dropdown-item" href="{{ route('laporan.keterlambatan') }}">Laporan Keterlambatan</a></li>
                            </ul>
                        </li>
                    @elseif(auth()->user()->role === 'owner')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Laporan
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="laporanDropdown">
                                <li><a class="dropdown-item" href="{{ route('laporan.kredit') }}">Laporan Kredit</a></li>
                                <li><a class="dropdown-item" href="{{ route('laporan.pembayaran') }}">Laporan Pembayaran</a></li>
                                <li><a class="dropdown-item" href="{{ route('laporan.nasabah') }}">Laporan Nasabah</a></li>
                                <li><a class="dropdown-item" href="{{ route('laporan.keterlambatan') }}">Laporan Keterlambatan</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
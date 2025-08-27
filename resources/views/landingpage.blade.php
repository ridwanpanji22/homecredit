<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bunda Kami - Aplikasi Kredit Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .hero {
      background: linear-gradient(to right, #1e90ff, #00bfff);
      color: white;
      padding: 100px 0;
    }
    .features-icon {
      font-size: 40px;
      color: #007bff;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
        <img src="{{ asset('Gambar&Video/MoneyUp-removebg-preview.png') }}" alt="Logo" width="40" class="me-2">
        Bunda Kami
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="#fitur">Kelebihan</a></li>
          <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
          <li class="nav-item">
            <a class="nav-link btn btn-warning text-white fw-bold px-3 d-flex align-items-center" href="/login">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-right me-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-1a.5.5 0 0 1 1 0v1h6V3H7v1a.5.5 0 0 1-1 0V3zm.146 4.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 1 1-.708-.708L7.293 10H1.5a.5.5 0 0 1 0-1h5.793l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
              </svg>
              Masuk Sebagai Pengguna
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero text-center">
    <div class="container">
    <h1 class="display-4 fw-bold">Selamat Datang di Bunda Kami,</h1>
      <h1 class="display-4 fw-bold">Mau Barang Impian? Bayar Nanti Aja!</h1>
      <p class="lead">Kini belanja makin mudah tanpa bikin dompet kaget!</p>
      <p class="lead">Di <b>Bunda Kami</b> kamu bisa punya barang impian sekarang juga.</p>
      <a href="http://wa.me/6281346353319" class="btn btn-light btn-lg text-primary mt-3">Hubungi Kami Sekarang</a>
    </div>
  </section>

  <!-- Features -->
  <section class="py-5" id="fitur">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="fw-bold"><b>Bayarnya dicicil ringan sesuai kemampuan!</b></h2>
      </div>
      <div class="row text-center">
        <div class="col-md-4 mb-4">
          <div class="features-icon mb-3">&#128241;</div>
          <h5>HP Terbaru? Bisa!</h5>
        </div>
        <div class="col-md-4 mb-4">
          <div class="features-icon mb-3">&#128716;</div>
          <h5>Perabot Rumah Tangga? Bisa!</h5>
        </div>
        <div class="col-md-4 mb-4">
          <div class="features-icon mb-3">&#128250;</div>
          <h5>Elektronik Canggih? Bisa Banget!</h5>
          </div>
      </div>
    </div>
  </section>

  <!-- About -->
  <section class="bg-light py-5" id="tentang">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h2 class="fw-bold">Kenapa Pilih Kredit di Sini?</h2>
          <ul class="list-unstyled fs-5">
            <li>✅ Proses cepat dan mudah</li>
            <li>✅ Tanpa jaminan</li>
            <li>✅ Cicilan fleksibel sesuai kemampuan</li>
            <li>✅ Aman dan terpercaya</li>
          </ul>
          <h4 class="fw-bold mt-4 text-danger">🎯 Gak perlu nunggu gajian!</h4>
          <p class="mb-2">Langsung aja ajukan kredit hari ini dan bawa pulang barangnya sekarang juga!</p>
          <p class="mb-1">📍 Kunjungi kami di: <b>Jl. Ibunda 1 Gang Nusantara No. 39</b></p>
          <p>📞 Hubungi kami: <b>0813-4635-3319</b></p>
        </div>
        <div class="col-md-6 text-center">
          <img src="{{ asset('Gambar&Video/image.png') }}" alt="Kredit Barang" width="250">
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-primary text-white text-center py-4">
    <p class="mb-0">&copy; 2025 UD Bunda Kami. Hubungi 081346353319</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

# Sistem Informasi Kredit Home Credit

Sistem informasi untuk mengelola kredit dan pembayaran dengan fitur multi-user (Admin, Owner, dan Nasabah).

## Persyaratan Sistem

- PHP 8.3 atau lebih tinggi
- Composer 2.7.1 atau lebih tinggi
- SQLite 3
- Node.js dan NPM (untuk asset compilation)
- Web Server (Apache/Nginx)

## Langkah Instalasi

1. Clone repository ini
```bash
git clone https://github.com/ridwanpanji22/homecredit.git
cd homecredit
```

2. Install dependensi PHP menggunakan Composer
```bash
composer install
```

3. Salin file .env.example menjadi .env
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Konfigurasi SQLite database
```bash
# Buat file database SQLite
touch database/database.sqlite

# Update konfigurasi di file .env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
# Hapus atau comment baris berikut
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_USERNAME=root
# DB_PASSWORD=
```

6. Set permission untuk database SQLite
```bash
# Pastikan file database.sqlite memiliki permission yang benar
chmod 664 database/database.sqlite
# Pastikan direktori database memiliki permission yang benar
chmod 775 database
```

7. Jalankan migrasi database dan seeder
```bash
php artisan migrate --seed
```

8. Buat symbolic link untuk storage
```bash
php artisan storage:link
```

9. Install dependensi JavaScript dan compile assets
```bash
npm install
npm run dev
```

10. Jalankan development server
```bash
php artisan serve
```

## Akun Default

Setelah menjalankan seeder, akan tersedia beberapa akun default:

1. Admin
   - Email: admin@example.com
   - Password: password

2. Owner
   - Email: owner@example.com
   - Password: password

3. Nasabah
   - Email: nasabah@example.com
   - Password: password

## Fitur Utama

1. Dashboard Admin
   - Kelola data nasabah
   - Kelola data barang
   - Kelola kredit
   - Verifikasi pembayaran
   - Laporan (kredit, pembayaran, nasabah, keterlambatan)

2. Dashboard Owner
   - Monitoring kredit
   - Monitoring pembayaran
   - Laporan lengkap dengan grafik

3. Dashboard Nasabah
   - Lihat riwayat kredit
   - Lihat riwayat pembayaran
   - Upload bukti pembayaran
   - Notifikasi keterlambatan

## Troubleshooting

1. Jika terjadi error permission pada storage:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

2. Jika terjadi error pada composer:
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

3. Jika terjadi error pada database SQLite:
```bash
# Pastikan file database ada
touch database/database.sqlite

# Set permission yang benar
chmod 664 database/database.sqlite
chmod 775 database

# Reset database jika diperlukan
php artisan migrate:fresh --seed
```

4. Jika path SQLite tidak ditemukan:
```bash
# Pastikan menggunakan absolute path di .env
# Contoh untuk Windows:
DB_DATABASE=C:/laragon/www/homecredit/database/database.sqlite
# Contoh untuk Linux/Mac:
DB_DATABASE=/var/www/homecredit/database/database.sqlite
```

## Kontribusi

Jika Anda menemukan bug atau ingin menambahkan fitur, silakan buat issue atau pull request.

## Lisensi

Sistem ini dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).

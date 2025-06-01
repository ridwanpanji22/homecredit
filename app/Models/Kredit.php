<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Kredit extends Model
{
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function barang() {
        return $this->belongsTo(Barang::class);
    }

    public function pembayarans() {
        return $this->hasMany(Pembayaran::class);
    }

    public function totalDibayar()
    {
        // Total pembayaran terverifikasi
        return $this->pembayarans()->where('status', 'terverifikasi')->sum('jumlah_pembayaran');
    }

    public function sisaTagihan()
    {
        return $this->total_harga - $this->totalDibayar();
    }

    public function tanggalJatuhTempoSelanjutnya()
    {
        // Ambil tanggal mulai dari kredit
        $mulai = Carbon::parse($this->tanggal_mulai);

        // Hitung jumlah cicilan yang sudah dibayar
        $totalPembayaran = $this->pembayarans()->where('status', 'terverifikasi')->count();

        // Tentukan tanggal jatuh tempo berdasarkan jenis kredit
        switch ($this->jenis_kredit) {
            case 'harian':
                // Untuk kredit harian, setiap cicilan bertambah 1 hari
                $jatuhTempo = $mulai->copy()->addDays($totalPembayaran);
                break;
            case 'mingguan':
                // Untuk kredit mingguan, setiap cicilan bertambah 1 minggu
                $jatuhTempo = $mulai->copy()->addWeeks($totalPembayaran);
                break;
            case 'bulanan':
                // Untuk kredit bulanan, setiap cicilan bertambah 1 bulan
                $jatuhTempo = $mulai->copy()->addMonths($totalPembayaran);
                break;
            default:
                // Jika jenis kredit tidak valid, buat jatuh tempo kosong
                $jatuhTempo = null;
                break;
        }

        return $jatuhTempo;
    }

    public function isMenunggak()
    {
        if($this->status !== 'aktif') return false;
        $jatuhTempo = $this->tanggalJatuhTempoSelanjutnya();
        return $jatuhTempo->lt(Carbon::today());
    }



}

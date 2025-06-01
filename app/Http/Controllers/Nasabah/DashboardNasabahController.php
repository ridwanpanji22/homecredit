<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kredit;
use App\Models\Pembayaran;

class DashboardNasabahController extends Controller
{
    public function index()
    {
        // Ambil kredit yang terkait dengan nasabah yang login
        $kredits = auth()->user()->kredits;
        return view('dashboard.nasabahDashboard.dashboard', compact('kredits'));
    }

    public function riwayatPembayaran()
    {
        // Ambil riwayat pembayaran untuk nasabah yang login
        $riwayatPembayaran = Pembayaran::with('kredit')
            ->whereHas('kredit', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();

        return view('dashboard.dasboardNasabah.riwayat', compact('riwayatPembayaran'));
    }
}

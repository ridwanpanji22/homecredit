<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kredit;
use App\Models\Pembayaran;
use App\Models\User;

class LaporanController extends Controller
{
    public function kredit(Request $request)
    {
        // Bisa filter status jika mau
        $status = $request->get('status');
        $kredits = Kredit::with('user','barang')
            ->when($status, fn($q) => $q->where('status', $status))
            ->get();
        return view('dashboard.laporan.kredit', compact('kredits','status'));
    }

    public function pembayaran(Request $request)
    {
        $status = $request->get('status');
        $pembayarans = Pembayaran::with('kredit.user','kredit.barang')
            ->when($status, fn($q) => $q->where('status', $status))
            ->get();
        return view('dashboard.laporan.pembayaran', compact('pembayarans','status'));
    }

    public function nasabah(Request $request)
    {
        $nasabahList = User::where('role', 'nasabah')->get();
        $selectedNasabah = $request->get('nasabah_id');
        $kredits = Kredit::with('barang','pembayarans')
            ->where('user_id', $selectedNasabah)
            ->get();
        return view('dashboard.laporan.nasabah', compact('nasabahList','kredits','selectedNasabah'));
    }

    public function keterlambatan()
    {
        // $kredits = Kredit::with(['user','barang','pembayarans'])
        //     ->where('status','aktif')
        //     ->get()
        //     ->filter->isMenunggak();
        // return view('dashboard.laporan.keterlambatan', compact('kredits'));

        $kredits = Kredit::with(['user', 'barang', 'pembayarans'])
            ->where('status', 'aktif')
            ->get()
            ->filter(function ($kredit) {
                // Filter kredit yang menunggak
                return $kredit->isMenunggak();
            });

        return view('dashboard.laporan.keterlambatan', compact('kredits'));
    }

}

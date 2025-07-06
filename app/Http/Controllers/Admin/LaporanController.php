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
        // Filter status dan jenis barang
        $status = $request->get('status');
        $jenisBarang = $request->get('jenis_barang');
        
        $kredits = Kredit::with('user','barang')
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($jenisBarang, function($query) use ($jenisBarang) {
                return $query->whereHas('barang', function($q) use ($jenisBarang) {
                    $q->where('jenis_barang', $jenisBarang);
                });
            })
            ->get();
            
        // Daftar jenis barang untuk filter
        $jenisBarangList = [
            'Elektronik',
            'Furniture', 
            'Kendaraan',
            'Pakaian',
            'Perhiasan',
            'Alat Rumah Tangga',
            'Gadget',
            'Olahraga',
            'Kesehatan',
            'Pendidikan'
        ];
        
        return view('dashboard.laporan.kredit', compact('kredits','status','jenisBarang','jenisBarangList'));
    }

    public function pembayaran(Request $request)
    {
        $status = $request->get('status');
        $nasabahId = $request->get('nasabah_id');
        $nasabahList = User::where('role', 'nasabah')->get();
        $pembayarans = Pembayaran::with('kredit.user','kredit.barang')
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($nasabahId, function($query) use ($nasabahId) {
                return $query->whereHas('kredit', function($q) use ($nasabahId) {
                    $q->where('user_id', $nasabahId);
                });
            })
            ->get();
        return view('dashboard.laporan.pembayaran', compact('pembayarans','status','nasabahList','nasabahId'));
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

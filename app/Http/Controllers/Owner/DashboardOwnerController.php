<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kredit;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardOwnerController extends Controller
{
    public function index()
    {
        $totalKredit = Kredit::count();
        $totalNasabah = User::where('role', 'nasabah')->count();
        $totalPembayaran = Pembayaran::where('status', 'terverifikasi')->sum('jumlah_pembayaran');
        $totalPiutang = Kredit::sum('total_harga') - $totalPembayaran;
        
        // Kredit yang menunggak
        $kreditMenunggak = Kredit::with(['user', 'barang'])
            ->where('status', 'aktif')
            ->get()
            ->filter(function ($kredit) {
                return $kredit->isMenunggak();
            });

        // Data untuk grafik pembayaran 6 bulan terakhir menggunakan fungsi SQLite
        $pembayaranBulanan = Pembayaran::where('status', 'terverifikasi')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw("strftime('%m', created_at) as bulan"),
                DB::raw("strftime('%Y', created_at) as tahun"),
                DB::raw('SUM(jumlah_pembayaran) as total')
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Konversi nomor bulan ke nama bulan
        $pembayaranBulanan = $pembayaranBulanan->map(function ($item) {
            $item->bulan_nama = Carbon::createFromDate(null, $item->bulan, 1)->format('F');
            return $item;
        });

        return view('dashboard.ownerDashboard.dashboard', compact(
            'totalKredit',
            'totalNasabah',
            'totalPembayaran',
            'totalPiutang',
            'kreditMenunggak',
            'pembayaranBulanan'
        ));
    }

    public function laporanKredit(Request $request)
    {
        $status = $request->get('status');
        $kredits = Kredit::with(['user', 'barang', 'pembayarans'])
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->get();

        return view('dashboard.ownerDashboard.laporan.kredit', compact('kredits'));
    }

    public function laporanPembayaran(Request $request)
    {
        $status = $request->get('status');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $pembayarans = Pembayaran::with(['kredit.user', 'kredit.barang'])
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($startDate && $endDate, function($query) use ($startDate, $endDate) {
                return $query->whereBetween('tanggal_pembayaran', [$startDate, $endDate]);
            })
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        return view('dashboard.ownerDashboard.laporan.pembayaran', compact('pembayarans'));
    }

    public function laporanNasabah(Request $request)
    {
        $nasabahId = $request->get('nasabah_id');
        $nasabahList = User::where('role', 'nasabah')->get();
        
        $kredits = Kredit::with(['barang', 'pembayarans'])
            ->when($nasabahId, function($query) use ($nasabahId) {
                return $query->where('user_id', $nasabahId);
            })
            ->get();

        return view('dashboard.ownerDashboard.laporan.nasabah', compact('kredits', 'nasabahList', 'nasabahId'));
    }

    public function laporanKeterlambatan()
    {
        $kredits = Kredit::with(['user', 'barang', 'pembayarans'])
            ->where('status', 'aktif')
            ->get()
            ->filter(function ($kredit) {
                return $kredit->isMenunggak();
            });

        return view('dashboard.ownerDashboard.laporan.keterlambatan', compact('kredits'));
    }
} 
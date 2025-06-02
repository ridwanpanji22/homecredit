<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kredit;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DashboardNasabahController extends Controller
{
    public function index()
    {
        // Ambil kredit yang terkait dengan nasabah yang login
        $kredits = auth()->user()->kredits;
        return view('dashboard.nasabahDashboard.dashboard', compact('kredits'));
    }

    public function riwayatPembayaran(Request $request, $kredit_id)
    {
        Log::info('Accessing riwayatPembayaran', [
            'kredit_id' => $kredit_id,
            'user_id' => auth()->id(),
            'request_path' => $request->path()
        ]);

        $kredit = Kredit::findOrFail($kredit_id);
        
        Log::info('Kredit found', [
            'kredit' => $kredit->toArray()
        ]);

        // Periksa apakah kredit ini milik nasabah yang sedang login
        if ($kredit->user_id !== auth()->id()) {
            Log::warning('Unauthorized access attempt', [
                'kredit_user_id' => $kredit->user_id,
                'auth_user_id' => auth()->id()
            ]);
            abort(403, 'Unauthorized action.');
        }

        // Ambil riwayat pembayaran untuk kredit yang terkait
        $riwayatPembayaran = Pembayaran::where('kredit_id', $kredit->id)
            ->orderBy('tanggal_pembayaran', 'asc')
            ->get();

        return view('dashboard.nasabahDashboard.riwayat', compact('riwayatPembayaran', 'kredit'));
    }

    public function uploadBuktiPembayaran(Request $request, $kredit_id, $pembayaran_id)
    {
        // Validasi request
        $request->validate([
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Ambil data kredit dan pembayaran
        $kredit = Kredit::findOrFail($kredit_id);
        $pembayaran = Pembayaran::findOrFail($pembayaran_id);

        // Periksa apakah kredit ini milik nasabah yang sedang login
        if ($kredit->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Periksa apakah pembayaran ini terkait dengan kredit yang benar
        if ($pembayaran->kredit_id !== $kredit->id) {
            abort(403, 'Invalid payment data.');
        }

        // Hapus bukti transfer lama jika ada
        if ($pembayaran->bukti_transfer) {
            Storage::disk('public')->delete($pembayaran->bukti_transfer);
        }

        // Upload file baru
        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        
        // Update data pembayaran
        $pembayaran->update([
            'bukti_transfer' => $path,
            'status' => 'menunggu_verifikasi'
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah dan menunggu verifikasi.');
    }
}

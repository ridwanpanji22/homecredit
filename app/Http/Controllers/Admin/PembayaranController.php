<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Kredit;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Kredit $kredit)
    {
        $pembayarans = $kredit->pembayarans()->orderBy('tanggal_pembayaran', 'desc')->get();
        return view('dashboard.pembayaran.index', compact('kredit', 'pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Kredit $kredit)
    {
        return view('dashboard.pembayaran.create', compact('kredit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Kredit $kredit)
    {
        $request->validate([
            'tanggal_pembayaran' => 'required|date',
            'jumlah_pembayaran' => 'required|integer|min:1',
            'bukti_transfer' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $data = $request->only(['tanggal_pembayaran', 'jumlah_pembayaran']);
        $data['kredit_id'] = $kredit->id;
        $data['status'] = 'menunggu_verifikasi';

        // upload file jika ada
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $data['bukti_transfer'] = $path;
        }

        Pembayaran::create($data);
        return redirect()->route('kredit.pembayaran.index', $kredit->id)->with('success', 'Pembayaran berhasil ditambahkan, menunggu verifikasi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kredit $kredit, Pembayaran $pembayaran)
    {
        return view('dashboard.pembayaran.edit', compact('kredit', 'pembayaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kredit $kredit, Pembayaran $pembayaran)
    {
        $request->validate([
            'tanggal_pembayaran' => 'required|date',
            'jumlah_pembayaran' => 'required|integer|min:1',
            'status' => 'required|in:menunggu_verifikasi,terverifikasi,gagal',
            'bukti_transfer' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $data = $request->only(['tanggal_pembayaran', 'jumlah_pembayaran', 'status']);

        // upload file jika ada
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $data['bukti_transfer'] = $path;
        }

        $pembayaran->update($data);
        return redirect()->route('kredit.pembayaran.index', $kredit->id)->with('success', 'Pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kredit $kredit, Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('kredit.pembayaran.index', $kredit->id)->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function verifikasi($kredit_id, $pembayaran_id)
    {
        $pembayaran = \App\Models\Pembayaran::where('kredit_id', $kredit_id)
            ->where('id', $pembayaran_id)
            ->firstOrFail();

        $pembayaran->status = 'terverifikasi';
        $pembayaran->save();

        // Otomatis update status kredit jika semua sudah lunas
        $kredit = $pembayaran->kredit;
        $totalDibayar = $kredit->pembayarans()->where('status', 'terverifikasi')->sum('jumlah_pembayaran');
        if ($totalDibayar >= $kredit->total_harga) {
            $kredit->status = 'lunas';
            $kredit->save();
        }

        return redirect()->route('kredit.pembayaran.index', $kredit_id)
            ->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    public function tolak($kredit_id, $pembayaran_id)
    {
        $pembayaran = \App\Models\Pembayaran::where('kredit_id', $kredit_id)
            ->where('id', $pembayaran_id)
            ->firstOrFail();

        $pembayaran->status = 'gagal';
        $pembayaran->save();

        return redirect()->route('kredit.pembayaran.index', $kredit_id)
            ->with('success', 'Pembayaran ditolak dan status diubah menjadi gagal.');
    }


}

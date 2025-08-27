<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kredit;
use App\Models\User;
use App\Models\Barang;
use Carbon\Carbon;
use App\Models\Pembayaran;

class KreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kredits = Kredit::with('user', 'barang')->get();
        return view('dashboard.kredit.index', compact('kredits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nasabahList = User::where('role', 'nasabah')->get();
        $barangList = Barang::all();
        return view('dashboard.kredit.create', compact('nasabahList', 'barangList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|integer|min:0',
            'uang_muka' => 'nullable|numeric|min:0|max:100',
            'jenis_kredit' => 'required|in:harian,mingguan,bulanan',
            'tenor' => 'required|integer|min:1',
            'status' => 'required|in:aktif,lunas,menunggak',
        ]);

        // Menghitung cicilan per periode
        $cicilan_per_periode = $request->total_harga / $request->tenor;

        // Tentukan tanggal mulai
        $tanggal_mulai = Carbon::parse($request->tanggal_mulai);

        // Menyimpan data kredit
        $kredit = Kredit::create([
            'user_id' => $request->user_id,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $request->total_harga,
            'uang_muka' => $request->uang_muka ?? 0,
            'jenis_kredit' => $request->jenis_kredit,
            'tenor' => $request->tenor,
            'cicilan_per_periode' => $cicilan_per_periode,
            'tanggal_mulai' => $tanggal_mulai,
            'status' => $request->status,
        ]);

        // Menentukan jadwal pembayaran berdasarkan jenis kredit
        $this->generateJadwalPembayaran($kredit, $tanggal_mulai);

        return redirect()->route('kredit.index')->with('success', 'Kredit berhasil ditambahkan!');
    }

    public function generateJadwalPembayaran(Kredit $kredit, Carbon $tanggal_mulai)
    {
        for ($i = 1; $i <= $kredit->tenor; $i++) {
            // Tentukan tanggal pembayaran berdasarkan jenis kredit
            switch ($kredit->jenis_kredit) {
                case 'harian':
                    $tanggal_pembayaran = $tanggal_mulai->copy()->addDays($i);
                    break;
                case 'mingguan':
                    $tanggal_pembayaran = $tanggal_mulai->copy()->addWeeks($i);
                    break;
                case 'bulanan':
                    $tanggal_pembayaran = $tanggal_mulai->copy()->addMonths($i);
                    break;
            }

            // Membuat entri pembayaran (menyimpan jadwal pembayaran)
            Pembayaran::create([
                'kredit_id' => $kredit->id,
                'tanggal_pembayaran' => $tanggal_pembayaran,
                'jumlah_pembayaran' => $kredit->cicilan_per_periode,
                'status' => 'menunggu_verifikasi',
            ]);
        }
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
    public function edit(Kredit $kredit)
    {
        $nasabahList = User::where('role', 'nasabah')->get();
        $barangList = Barang::all();
        return view('dashboard.kredit.edit', compact('kredit', 'nasabahList', 'barangList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kredit $kredit)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|integer|min:0',
            'uang_muka' => 'nullable|numeric|min:0|max:100',
            'cicilan_per_periode' => 'required|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'status' => 'required|in:aktif,lunas,menunggak',
        ]);
        $kredit->update($request->all());
        return redirect()->route('kredit.index')->with('success', 'Kredit berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kredit $kredit)
    {
        $kredit->delete();
        return redirect()->route('kredit.index')->with('success', 'Kredit berhasil dihapus!');
    }
}

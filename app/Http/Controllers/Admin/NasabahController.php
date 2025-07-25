<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Kredit;
class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $nasabahList = User::where('role', 'nasabah')->get();
    //     $kredits = Kredit::with(['user','barang','pembayarans'])->get();
    //     return view('dashboard.index', compact('nasabahList', 'kredits'));
    // }
    public function index()
    {
        $nasabahList = User::where('role', 'nasabah')->get();
        $kredits = Kredit::with(['user','barang','pembayarans'])->get();

        // Data ringkasan
        $totalKredit = Kredit::count();
        $totalNasabah = $nasabahList->count();
        $totalPembayaran = \App\Models\Pembayaran::where('status', 'terverifikasi')->sum('jumlah_pembayaran');
        $totalPiutang = Kredit::sum('total_harga') - $totalPembayaran;
        $kreditMenunggak = Kredit::with(['user', 'barang'])
            ->where('status', 'aktif')
            ->get()
            ->filter(function ($kredit) {
                return $kredit->isMenunggak();
            });
        $totalTunggakan = $kreditMenunggak->sum(function ($kredit) {
            return $kredit->sisaTagihan();
        });

        return view('dashboard.index', compact('nasabahList', 'kredits', 'totalKredit', 'totalNasabah', 'totalPembayaran', 'totalPiutang', 'kreditMenunggak', 'totalTunggakan'));
    }

    public function nasabah()
    {
        $nasabahList = User::where('role', 'nasabah')->get();
        $kredits = Kredit::with(['user','barang','pembayarans'])->get();

        // Data ringkasan
        $totalKredit = Kredit::count();
        $totalNasabah = $nasabahList->count();
        $totalPembayaran = \App\Models\Pembayaran::where('status', 'terverifikasi')->sum('jumlah_pembayaran');
        $totalPiutang = Kredit::sum('total_harga') - $totalPembayaran;
        $kreditMenunggak = Kredit::with(['user', 'barang'])
            ->where('status', 'aktif')
            ->get()
            ->filter(function ($kredit) {
                return $kredit->isMenunggak();
            });
        $totalTunggakan = $kreditMenunggak->sum(function ($kredit) {
            return $kredit->sisaTagihan();
        });

        return view('dashboard.nasabah', compact('nasabahList', 'kredits', 'totalKredit', 'totalNasabah', 'totalPembayaran', 'totalPiutang', 'kreditMenunggak', 'totalTunggakan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users,phone',
            'no_ktp' => 'required|unique:users,no_ktp',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoKtpPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoKtpPath = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'no_ktp' => $request->no_ktp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'nasabah',
            'foto_ktp' => $fotoKtpPath,
        ]);

        return redirect()->route('admin.index')->with('success', 'Nasabah berhasil ditambah.');
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
    public function edit(string $id)
    {
        $nasabah = User::where('role', 'nasabah')->findOrFail($id);
        return view('dashboard.edit', compact('nasabah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nasabah = \App\Models\User::where('role', 'nasabah')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users,phone,' . $nasabah->id,
            'no_ktp' => 'required|unique:users,no_ktp,' . $nasabah->id,
            'email' => 'required|email|unique:users,email,' . $nasabah->id,
            'password' => 'nullable|min:6',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $nasabah->name = $request->name;
        $nasabah->phone = $request->phone;
        $nasabah->no_ktp = $request->no_ktp;
        $nasabah->email = $request->email;
        if ($request->password) {
            $nasabah->password = Hash::make($request->password);
        }
        if ($request->hasFile('foto_ktp')) {
            // Hapus file lama jika ada
            if ($nasabah->foto_ktp && \Storage::disk('public')->exists($nasabah->foto_ktp)) {
                \Storage::disk('public')->delete($nasabah->foto_ktp);
            }
            $nasabah->foto_ktp = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }
        $nasabah->save();

        return redirect()->route('admin.index')->with('success', 'Data nasabah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nasabah = \App\Models\User::where('role', 'nasabah')->findOrFail($id);
        $nasabah->delete();

        return redirect()->route('admin.index')->with('success', 'Nasabah berhasil dihapus.');
    }
}

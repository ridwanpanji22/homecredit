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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'nasabah'
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
            'email' => 'required|email|unique:users,email,' . $nasabah->id,
            'password' => 'nullable|min:6',
        ]);

        $nasabah->name = $request->name;
        $nasabah->phone = $request->phone;
        $nasabah->email = $request->email;
        if ($request->password) {
            $nasabah->password = Hash::make($request->password);
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

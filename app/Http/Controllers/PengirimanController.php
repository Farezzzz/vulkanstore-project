<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    /**
     * Menampilkan daftar pengiriman
     */
    public function index(Request $request)
    {
        $query = Pengiriman::with('pesanan'); 

        $pengiriman = $query->latest('ID_Pengiriman')->paginate(5);
        $pesanan = Pesanan::all();

        return view('pengiriman.index', compact('pengiriman', 'pesanan'));
    }

    /**
     * Menyimpan data pengiriman baru
     */
    public function store(Request $request)
    {
        // Validasi dibuat agar menerima variasi huruf besar/kecil (lowercase, uppercase, camelcase)
        $request->validate([
            'ID_Pesanan'        => 'required|exists:pesanan,ID_Pesanan',
            'Tanggal_Kirim'     => 'required|date',
            'Status_Pengiriman' => 'required|in:Disiapkan,Dikirim,Selesai,disiapkan,dikirim,selesai,DISIAPKAN,DIKIRIM,SELESAI',
        ]);

        // Format otomatis agar huruf pertama kapital (contoh: "Dikirim") sesuai standard ENUM database
        $statusDiformat = ucfirst(strtolower($request->Status_Pengiriman));

        Pengiriman::create([
            'ID_Pesanan'        => $request->ID_Pesanan,
            'Tanggal_Kirim'     => $request->Tanggal_Kirim,
            'Status_Pengiriman' => $statusDiformat,
        ]);

        return redirect()->route('pengiriman.index')->with('success', 'Data pengiriman berhasil dibuat!');
    }

    /**
     * Menampilkan detail pengiriman beserta barangnya
     */
    public function show(string $id)
    {
        $pengiriman = Pengiriman::with('pesanan.detailPesanan.barang')->findOrFail($id);

        return view('pengiriman.show', compact('pengiriman'));
    }

    /**
     * Menampilkan halaman edit pengiriman
     */
    public function edit(string $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        return view('pengiriman.edit', compact('pengiriman'));
    }

    /**
     * Memperbarui data pengiriman secara manual via form edit
     */
    public function update(Request $request, string $id)
    {
        // Validasi dibuat fleksibel terhadap huruf kapital/kecil
        $request->validate([
            'Status_Pengiriman' => 'required|in:Disiapkan,Dikirim,Selesai,disiapkan,dikirim,selesai,DISIAPKAN,DIKIRIM,SELESAI',
        ]);

        $pengiriman = Pengiriman::findOrFail($id);

        // Format huruf pertama menjadi kapital sebelum disimpan
        $statusDiformat = ucfirst(strtolower($request->Status_Pengiriman));

        $pengiriman->update([
            'Status_Pengiriman' => $statusDiformat,
        ]);

        return redirect()->route('pengiriman.index')->with('success', 'Status pengiriman berhasil diperbarui!');
    }

    /**
     * Memperbarui status secara berjenjang/linear otomatis (Dipicu dari tombol detail show.blade.php)
     */
    public function updateStatus(Request $request, $id)
{
    $pengiriman = Pengiriman::findOrFail($id);
    $currentStatus = strtolower($pengiriman->Status_Pengiriman);

    if ($currentStatus === 'disiapkan') {
        $pengiriman->Status_Pengiriman = 'Dikirim';
    } elseif (in_array($currentStatus, ['dikirim', 'diantar', 'diantarkan'])) {
        $pengiriman->Status_Pengiriman = 'Selesai';
    } else {
        // UBAH DISINI: Arahkan langsung ke route show, jangan pakai back()
        return redirect()->route('pengiriman.show', $id)->with('error', 'Status tidak dapat diperbarui lagi.');
    }

    $pengiriman->save();

    // UBAH DISINI JUGA: Arahkan langsung ke route show agar kembali dengan method GET yang benar
    return redirect()->route('pengiriman.show', $id)->with('success', 'Status berhasil diperbarui menjadi: ' . $pengiriman->Status_Pengiriman);
}

    /**
     * Menghapus data pengiriman
     */
    public function destroy(string $id)
    {
        try {
            $pengiriman = Pengiriman::findOrFail($id);
            $pengiriman->delete();

            return redirect()->route('pengiriman.index')->with('success', 'Data pengiriman berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('pengiriman.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}